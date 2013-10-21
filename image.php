/************************************************
  Upload new Img:
  1. Generate Thumb
  2. Crop round
  3. Merge Two Images(Overlap)
*************************************************/
function testimg(){		
  if(isset($_FILES['userfile']) && $_FILES['userfile']['name']!='')
  {
        // mprd($_FILES);            
        //DEFINE VARIABLES ARRAY
        $targetpath = IMGROOTER;

        $config['upload_path'] = $targetpath;
        /*$config['allowed_types'] = 'gif|jpg|png|doc|txt|pdf|xls|docx|xlsx';*/
        // $config['allowed_types'] = '*';
        $config['allowed_types'] = 'gif|jpg|png|jpeg';
        $config['max_size']  = 1024 * 5;
        $config['encrypt_name'] = TRUE;
        $config['overwrite'] = false;

        $this->load->library('upload', $config);

        $this->upload->initialize($config);
        if ($this->upload->do_upload())
        {
            extract($this->upload->data());
            // $postData['vProfilePicName'] = $file_name;
            $postData['temporary_file'] = $file_name;
            $mypath=IMGROOTER.$file_name;
            /*Create Thumb*/
            $hasTh=$this->make_thumb($mypath);

            if($hasTh!=''){
            	$final=$hasTh.$file_name;
            	/*Create Rounded Thumb*/
            	$roundImgPath=$this->createRounder($final,$file_name);
            	$filename_result=IMGROOTER."thumb/".$file_name;
            	/*Merge Two Images*/
            	//$this->merge($roundImgPath, $final, $filename_result);
            }
            // unlink($mypath);
        }
        else{
            $err = array('MESSAGE' => $this->upload->display_errors());
            echo json_encode($err);
        }            
    }
}
/***************************************************
    Make Thumb of an Image
****************************************************/
public function make_thumb($mypath)
 {
        //$this->load->library('image_lib');
        $source_path = $mypath;
        $list=list($width, $height) = getimagesize($mypath);
        $ratio=150.00/min($width, $height);
        $w=$width*$ratio;
        $h=$height*$ratio;
        $target_path = IMGROOTER."files/";
        $config_manip = array(
            'image_library' => 'gd2',
            'source_image' => $source_path,
            'new_image' => $target_path,
            'maintain_ratio' => TRUE,
            'create_thumb' => FALSE,
            //'thumb_marker' => '_thumb',
            'width' => $w,
            'height' =>$h
        );
        $this->load->library('image_lib', $config_manip);
        if (!$this->image_lib->resize()) {
            echo $this->image_lib->display_errors();
        }
        else{
        	return $target_path;
        }

}
/***************************************************
    Make Circle Thumb of an Image
****************************************************/
public function createRounder($mypath2,$file_name)
{
        //$this->load->library('image_lib');
        $source_path = $mypath2;

        // $list=list($width, $height) = getimagesize($mypath2);
        $target_path = IMGROOTER."rounder/".$file_name;
        
        $tempfile = $mypath2;
        $outfile = $target_path;

        $circle = new Imagick();
        $circle->newImage(150, 150, 'none');
        $circle->setimageformat('png');
        $circle->setimagematte(true);
        $draw = new ImagickDraw();
        $draw->setfillcolor('#ffffff');
        $draw->circle(150/2, 150/2, 150/2, 150);
        $circle->drawimage($draw);

        $imagick = new Imagick();
        $imagick->readImage($tempfile);
        $imagick->setImageFormat( "png" );
        $imagick->setimagematte(true);
        $imagick->cropimage(150,150,0,0);
        //$imagick->cropThumbnailImage (148,148);
        $imagick->compositeimage($circle, Imagick::COMPOSITE_DSTIN, 0, 0);
        $imagick->writeImage($outfile);
        $imagick->destroy();
        return $target_path;
}
/***************************************************
    Merge Two Images
****************************************************/
// function merge($filename_x, $filename_y, $filename_result) {
function merge() {
	$filename_x=IMGROOTER.'base.png';
	$filename_y=IMGROOTER.'top.png';
	$filename_result=IMGROOTER.'test.png';
	$width = 200;
	$height = 200;

	$base_image = imagecreatefromjpeg($filename_x);
	$top_image = imagecreatefrompng($filename_y);
	$merged_image = $filename_result;

	imagesavealpha($top_image, true);
	imagealphablending($top_image, true);

	imagecopy($base_image, $top_image, 0, 0, 0, 0, $width, $height);
	imagepng($base_image, $merged_image);
}
