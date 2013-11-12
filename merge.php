function merge() {
		$filename_x=IMGROOTER.'thor.png';
		$filename_y=IMGROOTER.'outer-bg1_revised.png';
		$filename_result=IMGROOTER.'hulk12112013.png';
		$width = 200;
		$height = 200;

		$base_image = imagecreatefrompng($filename_x);
		$top_image = imagecreatefrompng($filename_y);
		$merged_image = $filename_result;

		imagesavealpha($top_image, true);
		imagealphablending($top_image, true);

		imagecopy($base_image, $top_image, 0, 0, 0, 0, $width, $height);
		imagepng($base_image, $merged_image);
	}
	function profileImg_maker($base=''){
		$basei=IMGROOTER.'17-13_spring_flower_png24.png';
		$maski=IMGROOTER.'inner-bg3.png';
		$overi=IMGROOTER.'outer-bg1_revised257.png';

		$out=IMGROOTER.'jaiminvaja.png';

		$base = new Imagick("$basei");
		$mask = new Imagick("$maski");
		$over = new Imagick("$overi");
		
		$oh=imagecreatefrompng($basei);
		imagesavealpha($oh, true);
		imagealphablending($oh, true);

		// Setting same size for all images
		$base->resizeImage(257, 257, Imagick::FILTER_LANCZOS, 1);

		// Copy opacity mask
		$base->compositeImage($mask, Imagick::COMPOSITE_DSTIN, 0, 0, Imagick::CHANNEL_ALPHA);

		// Add overlay
		$base->compositeImage($over, Imagick::COMPOSITE_DEFAULT, 0, 0);
		$base->paintTransparentImage($base->getImagePixelColor(0, 0), 0,0);
		$base->writeImage($out);
		// header("Content-Type: image/png");
	}
	function sims(){
		$pn=IMGROOTER.'outer-bg1_revised257.png';
		$jp=IMGROOTER.'thor.png';
		$dest = imagecreatefrompng($pn);
		$src = imagecreatefrompng($jp);
		$fin=IMGROOTER.'zzz.png';
		imagealphablending($dest, false);
		imagesavealpha($dest, true);

		imagecopymerge($dest, $src, 0,0, 0, 0, 257, 257, 100); //have to play with these numbers for it to work for you, etc.

		// header('Content-Type: image/png');
		imagepng($dest,$fin);

		imagedestroy($dest);
		imagedestroy($src);
	}
	function mergesasdf(){
		$width = 257;
		$height = 257;

		$pn=IMGROOTER.'outer-bg1_revised257.png';
		$jp=IMGROOTER.'thasdfor.png';
		//$jp=IMGROOTER.'thor.png';

		$base_image = imagecreatefrompng($jp);
		$top_image = imagecreatefrompng($pn);
		$merged_image =IMGROOTER."merged.png";

		imagesavealpha($base_image, true);
		imagealphablending($base_image, true);

		imagecopy($base_image, $top_image, 0, 0, 0, 0, $width, $height);
		imagepng($base_image, $merged_image);
	}
	function resoz(){
		$basei=IMGROOTER.'hulk.png';
		$base = new Imagick("$basei");
		$base->resizeImage(105, 105, Imagick::FILTER_LANCZOS, 1);
		$out=IMGROOTER.'jaiminvaja.png';
		$base->writeImage($out);
	}
	function mrg(){
		$width = 257;
		$height = 257;
		
		$pn=IMGROOTER.'jaiminvaja.png';
		$jp=IMGROOTER.'trnsprnt_bg.png';
		//$jp=IMGROOTER.'thor.png';

		$base_image = imagecreatefrompng($jp);
		$top_image = imagecreatefrompng($pn);
		$merged_image =IMGROOTER."xyz.png";

		imagesavealpha($base_image, true);
		imagealphablending($base_image, true);

		//imagecopy($base_image, $top_image, 76,76,0,0,$width,$height);
		imagecopymerge($base_image, $top_image,76,76,0,0, 257,257, 0);
		imagepng($base_image, $merged_image);
	}
