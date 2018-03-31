<?php

	/*
	此为PHP 生成 zip 压缩包的类
	faisun (faisun@sina.com) 编写
	http://www.artweaver.net
	*/

class PHPzip
{
	var $file_count = 0 ;
	var $datastr_len   = 0;
	var $dirstr_len = 0;
	var $filedata = ''; //该变量只被类外部程序访问

	/*
	返回文件的修改时间格式.
	只为本类内部函数调用.
	*/
    function unix2DosTime($unixtime = 0) {
        $timearray = ($unixtime == 0) ? getdate() : getdate($unixtime);

        if ($timearray['year'] < 1980) {
        	$timearray['year']    = 1980;
        	$timearray['mon']     = 1;
        	$timearray['mday']    = 1;
        	$timearray['hours']   = 0;
        	$timearray['minutes'] = 0;
        	$timearray['seconds'] = 0;
        }

        return (($timearray['year'] - 1980) << 25) | ($timearray['mon'] << 21) | ($timearray['mday'] << 16) |
               ($timearray['hours'] << 11) | ($timearray['minutes'] << 5) | ($timearray['seconds'] >> 1);
    }
	/*
	对现有的 zip 文件进行分析,
	得到它的结构.
	只为本类内部函数调用.
	*/
	function parsefile($gzfilename,&$dirstr){
		clearstatcache();
		if(!file_exists("$gzfilename")) return '';
		
		$newsize=filesize($gzfilename)-22;
		if($newsize==-22){ return ''; }
		elseif($newsize<0){	die("$gzfilename is a bad file.");	}

		$fp=fopen($gzfilename,"r");
		rewind($fp);
		fseek($fp,$newsize);
		$endstr = fread($fp,22);
		$this -> file_count = implode('',unpack('v',substr($endstr,8,2)));		//包含文件个数
		$this -> dirstr_len = implode('',unpack('V',substr($endstr,12,4)));		//目录信息长度
		$this -> datastr_len =  implode('',unpack('V',substr($endstr,16,4)));	//文件内容长度
		if($newsize != ($this->dirstr_len) + ($this->datastr_len)){	die("$gzfilename is a bad file.");	}

		rewind($fp);
		fseek($fp,$this->datastr_len);
		$dirstr=fread($fp,$this->dirstr_len);	//目录信息字符串
		fclose($fp);
	}

	/*
	初始化文件,建立文件目录,
	并返回文件的写入权限.
	在执行 addfile() 之前,不一定要调用本函数
	*/
	function startfile($gzfilename){
		$path=$gzfilename;
		$mypathdir=array();
		do{
			$mypathdir[] = $path = dirname($path);
		}while($path != '.');
		@end($mypathdir);
		while(@prev($mypathdir)){
			$path = @current($mypathdir);
			@mkdir($path);
		}

		if($fp=@fopen($gzfilename,"w")){
			fclose($fp);
			return true;
		}
		return false;
	}

	/*
	添加一个文件到 zip 压缩包中.
	若该 zip 文件已存在,它的内容必须是正确的.
	函数本身不检测文件名 $name 的正确性,但您必须保证它是合法的,否则无法解压,
	但它也可以是带目录的地址,例如 faisunsql/index.php
	每次调用本函数,所生成的 zip 文件都是完整的,您可以用相关软件读取或解压.
	*/
    function addfile($data, $name, $gzfilename){
	
		$this->parsefile($gzfilename,$pre_dirstr);	//分析压缩包

		$fp = fopen("$gzfilename","a");
		ftruncate($fp,$this->datastr_len); //剪裁压缩包到只剩文件内容

        $name     = str_replace('\\', '/', $name);
        $dtime    = dechex($this->unix2DosTime());
        $hexdtime = '\x' . $dtime[6] . $dtime[7]
                  . '\x' . $dtime[4] . $dtime[5]
                  . '\x' . $dtime[2] . $dtime[3]
                  . '\x' . $dtime[0] . $dtime[1];
        eval('$hexdtime = "' . $hexdtime . '";');

        $unc_len = strlen($data);
        $crc     = crc32($data);
        $zdata   = gzcompress($data);
        $c_len   = strlen($zdata);
        $zdata   = substr(substr($zdata, 0, strlen($zdata) - 4), 2);
		
		//新添文件内容格式化:
        $datastr  = "\x50\x4b\x03\x04";
        $datastr .= "\x14\x00";            // ver needed to extract
        $datastr .= "\x00\x00";            // gen purpose bit flag
        $datastr .= "\x08\x00";            // compression method
        $datastr .= $hexdtime;             // last mod time and date
        $datastr .= pack('V', $crc);             // crc32
        $datastr .= pack('V', $c_len);           // compressed filesize
        $datastr .= pack('V', $unc_len);         // uncompressed filesize
        $datastr .= pack('v', strlen($name));    // length of filename
        $datastr .= pack('v', 0);                // extra field length
        $datastr .= $name;
        $datastr .= $zdata;
        $datastr .= pack('V', $crc);                 // crc32
        $datastr .= pack('V', $c_len);               // compressed filesize
        $datastr .= pack('V', $unc_len);             // uncompressed filesize

		fwrite($fp,$datastr);	//写入新的文件内容
		$my_datastr_len = strlen($datastr);
		unset($datastr);

		fwrite($fp,$pre_dirstr);	//写入原有的文件目录信息
		unset($pre_dirstr);
		
		//新添文件目录信息
        $dirstr  = "\x50\x4b\x01\x02";
        $dirstr .= "\x00\x00";                	// version made by
        $dirstr .= "\x14\x00";                	// version needed to extract
        $dirstr .= "\x00\x00";                	// gen purpose bit flag
        $dirstr .= "\x08\x00";                	// compression method
        $dirstr .= $hexdtime;                 	// last mod time & date
        $dirstr .= pack('V', $crc);           	// crc32
        $dirstr .= pack('V', $c_len);         	// compressed filesize
        $dirstr .= pack('V', $unc_len);       	// uncompressed filesize
        $dirstr .= pack('v', strlen($name) ); 	// length of filename
        $dirstr .= pack('v', 0 );             	// extra field length
        $dirstr .= pack('v', 0 );             	// file comment length
        $dirstr .= pack('v', 0 );             	// disk number start
        $dirstr .= pack('v', 0 );             	// internal file attributes
        $dirstr .= pack('V', 32 );            	// external file attributes - 'archive' bit set
        $dirstr .= pack('V',$this->datastr_len ); // relative offset of local header
        $dirstr .= $name;
		
		$this -> file_count ++;
		$this -> dirstr_len += strlen($dirstr);
		$this -> datastr_len += $my_datastr_len;
		
		//压缩包结束信息,包括文件总数,目录信息读取指针位置等信息
		$endstr = "\x50\x4b\x05\x06\x00\x00\x00\x00" .
					pack('v', $this -> file_count) .
					pack('v', $this -> file_count) .
					pack('V', $this -> dirstr_len) .
					pack('V', $this -> datastr_len) .
					"\x00\x00";

		fwrite($fp,$dirstr.$endstr);//写入新添文件目录信息和压缩包结束信息
		fclose($fp);
    }
}

	/*
	应用举例:
	
	$faisunZIP = new PHPzip;
	$gzfilename = "zipfiles/mygz.zip";	//压缩包路径
	$faisunZIP -> startfile($gzfilename); //若 $gzfilename 是一个合法的压缩包,您想把文件添加到该包里,该函数可以省略
	$faisunZIP -> addfile("Created by faisun(faisun@sina.com),2005","faisun/copyright.txt",$gzfilename);
	$faisunZIP -> addfile("http://www.artweaver.net","faisun/my homepage.txt",$gzfilename);
	*/

?>