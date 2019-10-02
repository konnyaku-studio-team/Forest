<?php
//functions
//start
function getfile($filename)
{
	$f=fopen($filename,"r");
	$get=fgets($f);
	$return=$get;
	while(!feof($f))
	{
		$get=fgets($f);
		$return.=$get;
	}
	fclose($f);
	$return=explode(":",$return);
	return $return; 
}
function md2html($tohtml)
{
	nl2br($tohtml);
	$tohtml=iconv("GBK","utf-8",$tohtml);
	$i=0;
	for($i=0;$i<strlen($tohtml);$i++)
	{
		if($tohtml[$i]=='#')
		{
			if($tohtml[$i+1]=='#')
			{
				if($tohtml[$i+2]=='#')
				{
					$mem="h3";
					echo"<h3>";
					$i+=2;
				}
				$mem="h2";
				echo "<h2>";
				$i++;
			}
			$mem="h1";
			echo "<h1>";
		}
		else
		{
			if($tohtml[$i]=='<')
			{
				if($tohtml[$i+1]=='b')
				{
					if($tohtml[$i+2]=='r')
					{
						if($tohtml[$i+3]=='>')
						{
							if(!empty($mem))
							{
								echo "</".$mem.">";
								$i+=3;
							}
						}
					}
				}
			}
			else
			{
				echo $tohtml[$i];
			}
		}
	}
}
//end;
header("charset:gbk");
$blog_file=glob('*.md');
if(!include("forest.setting.php"))
{
	$icon="https://s2.ax1x.com/2019/10/03/uwZAxJ.png";
	$blogname="forest";
}
echo "<img src=".$icon." width=256 height=144 alt=".$blogname."></img><hr>";
foreach($blog_file as $i)
{
	$ref=getfile($i);
	echo "<h3>标题：".iconv("GBK","utf-8",$ref[3])."</h3>";
	echo "<h4>作者：".iconv("GBK","utf-8",$ref[1])."</h4>";
	echo "<h5>描述：</h5>";
	echo md2html($ref[5])."";
	echo "<hr>";
}
echo "<p align=\"center\">自豪的采用forest blog 由蒟蒻工作室提供支持。ForestBlog版本:Ver 0.0.1.1003(Alpha)</p>";
?>
