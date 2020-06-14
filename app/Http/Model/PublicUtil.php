<?php namespace App\Http\Model;


use DB;
use Route;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Input;
use Image;
use Carbon\Carbon;
use App\Http\Model\Constant;
use Youtube;
use App\Tag;

class PublicUtil{
/*
------------------------------------------------------------------------------------------------------------
以下是專案使用
------------------------------------------------------------------------------------------------------------
*/



	/*
		上傳單一圖檔，壓縮圖片檔案，並在本地端移動在upload資料夾，被picsUpload取代
		$request 使用的request方法
		$picName 圖片欄位名稱
		$width 寬度
		$height 高度
		$isResize 是否要resize
	*/
	public static function picUpload(Request $request , $picName = 'image' , $width = 350 , $height = 200 , $isResize = false , $uploadFolder = '' )
	{
		//dd($request);
		$inputs = $request ->all();
		$value = $request->file($picName);
	  	$isFail = false;
	  	//dd($file);
	  	if ($value->isValid())
		{
			$destinationPath = 'images/' . $uploadFolder; // upload path
   			$extension = $value->getClientOriginalExtension(); // getting image extension
 			$fileName = PublicUtil::randomFileName(12) .'.' . $extension; // renameing image
 			Input::file($picName)->move($destinationPath, $fileName); // uploading file to given path
 			//$data['filename'] = $fileName;//因為表格內沒有這個屬性，所以要自行新增
 			if ($isResize) {
 				$img = Image::make('images/'. $uploadFolder . $fileName)->resize($width, $height)->save();//上傳後規定的大小
 			}
  			//dd($fileName);
    	}
    	else
    	{
    		// sending back with error message.
    		$isFail = true;
   			$fileName = null;
   		}
 		if (!$isFail)
 		{
  			return $fileName;
  		}
  		else
  		{
  			return null;
  		}
	}

	/*
		上傳多個圖檔，壓縮圖片檔案，並在本地端移動到upload資料夾，並複製一份到full/upload資料夾
		$request 使用的request方法
		$picName 圖片欄位名稱
		$width 寬度
		$height 高度
		$isResize 是否要resize
	*/
	public static function picsUpload(Request $request , $picsName = 'image' , $width = 350 , $height = 200 , $isResize = true)
	{
		// getting all of the post data
	    $files = Input::file($picsName);
	    // Making counting of uploaded images
	    $file_count = count($files);
	    // start count how many uploaded
	    $uploadcount = 0;
	    $fileNames = array();
	    foreach($files as $file) {
	    	$destinationPath = 'images/' . Constant::upload_folder;
	        $extension = $file->getClientOriginalExtension(); // getting image extension
 			$fileName = PublicUtil::randomFileName(12) .'.' . $extension; // renameing image
 			$file->move($destinationPath, $fileName); // uploading file to given path
 			//複製一份到images/full資料夾
 			Image::make($destinationPath .$fileName)->save( 'images/full/'.Constant::upload_folder .$fileName);
 			//重新調整原圖大小
 			if ($isResize) {
 				Image::make($destinationPath .$fileName)->resize($width, $height)->save();//上傳後規定的大小
 			}

 			$fileNames[] = Constant::upload_folder . $fileName;
	        $uploadcount ++;
	    }
	    if($uploadcount == $file_count){
	    	return $fileNames;
	    }else{
	    	return null;
	    }
	}

	/*
		上傳多個檔案，並在本地端移動到upload資料夾
		$request 使用的request方法
		$picName 圖片欄位名稱
	*/
	public static function filesUpload(Request $request , $fieldName = 'files_upload')
	{
		// getting all of the post data
	    $files = Input::file($fieldName);
	    // Making counting of uploaded images
	    $file_count = count($files);
	    // start count how many uploaded
	    $uploadcount = 0;
	    $fileNames = array();
	    foreach($files as $file) {
	    	$destinationPath = 'files/' . Constant::upload_folder;
	        $extension = $file->getClientOriginalExtension(); // getting image extension
 			$fileName = PublicUtil::randomFileName(12) .'.' . $extension; // renameing image
 			$file->move($destinationPath, $fileName); // uploading file to given path
 			$fileNames[] = Constant::upload_folder . $fileName;
	        $uploadcount ++;
	    }
	    if($uploadcount == $file_count){
	    	return $fileNames;
	    }else{
	    	return null;
	    }
	}

	/*
		主要為選擇你想要刪除的檔案
		$dirName 刪除檔案名稱，或者資料夾
	*/
	public static function delFile($dirName)
	{
		if(file_exists($dirName) && $handle=opendir($dirName))
		{
			while(false!==($item = readdir($handle)))
			{
			if($item!= "." && $item != "..")
			{
				if(file_exists($dirName.'/'.$item) && is_dir($dirName.'/'.$item))
				{
					delFile($dirName.'/'.$item);
				}
				else
				{
					if(unlink($dirName.'/'.$item))
					{
						return true;
					}
				}
			}
		}
			closedir( $handle);
		}
	}

	//製作標籤字串，在標籤字串的頭和尾加上,。$tagsStr為待處理的標籤字串
	public static function buildTagString( $tagsStr){
		if (strlen(trim($tagsStr)) > 0) {
			$tags = explode(',', $tagsStr);
			$tag_str = ',';
			for ($i=0; $i < count($tags); $i++) {
				$tag_str = $tag_str  . $tags[$i] . ',';
			}
			return $tag_str;
		}else{
			return null;
		}
	}

	//將標籤ids字串，轉換成標籤標題字串
	public static function transferTagIdsToTagTitles( $tagsStr){
		if (isset($tagsStr) && strlen($tagsStr) > 0) {
			$str_tags = substr($tagsStr , 1 , count($tagsStr)-2);
			$tag_ary = explode(',' , $str_tags);
			for ($i=0; $i < count($tag_ary) ; $i++) {
				$tag = Tag::findOrFail($tag_ary[$i]);
				$tag_ary[$i] = $tag->title;
			}
			return implode("," , $tag_ary);
		}else{
			return null;
		}
	}

	//取得Storage資料夾裡頭子資料夾的檔案清單，isPath是否包含路徑
	public static function getFolderAry($dictionary,$isPath){
		$_results = Storage::files($dictionary);
		if (!$isPath) {
			$results= array();
	        foreach ($_results as $value) {
	            $results[] = str_replace($dictionary.'/','',$value);
	        }
	        return $results;
		}
		return $_results;
	}

	//將影片上傳到Youtube
	public static function uploadVideo($file, $title , $desc , $tags = ['goblinlab', 'program', 'laravel'] , $cgy_id = 27 ,$thumb = 'app/public/thumbnail.jpg'){
		$fullpathToImage = storage_path($thumb);
		$fullPathToVideo = storage_path($file);
		$video = Youtube::upload($fullPathToVideo, [
		    'title'       => $title,
		    'description' => $desc,
		    'tags'	      => $tags,
		    'category_id' => $cgy_id,
		],'unlisted')->withThumbnail($fullpathToImage);

		return $video->getVideoId();
	}


/*
------------------------------------------------------------------------------------------------------------
以下是 公共使用 使用
------------------------------------------------------------------------------------------------------------
*/

	/*
	  *  生成隨機的檔名
	  *  $qty 可傳入檔名的長度
	  */
	public static function randomFileName($qty)
	{
		$ran_chars = '1234567890abcdefghijklmnopqrstuvwxyz';
		$ran_string = '';
		for($i = 0; $i < $qty; $i++){
			$ran_string .= $ran_chars[rand(0, 35)];
		}
		return $ran_string;
	}

	/*處理傳入的圖片路徑，去除public/uploads/之後回傳圖片檔名
	 *$imagePath   位於public/uploads/裏頭的圖片路徑
	 */
	public static function getImageName($imagePath)
	{
	    $image_name = str_replace('public/images/uploads/' , '' , $imagePath);
	    return $image_name;
	}

	/*
	 * 建立FB大頭照網址
	 */
	public static function buildFbPicPath($fb_id)
	{
		return 'https://graph.facebook.com/' . $fb_id . '/picture?type=large';
	}

	// /*
	//  * 將時間字串轉換成Carbon型別
	//  */
	// public static function timeToCarbon($time)
	// {
	// 	return Carbon::parse($time);
	// }

	//將Carbon型別轉換為日期格式
	public static function carbonToDate($carbon)
	{
		return $carbon->format('m/d/Y');
	}

	//檢查某字串的開頭是否為該子字串,$haystack為受檢查字串，$needle為要比對字串
	public static function startsWith($haystack, $needle) {
	    return $needle === "" || strrpos($haystack, $needle, -strlen($haystack)) !== false;
	}

	//檢查某字串的結尾是否為該子字串,$haystack為受檢查字串，$needle為要比對字串
	public static function endsWith($haystack, $needle) {
	    // search forward starting from end minus needle length characters
	    return $needle === "" || (($temp = strlen($haystack) - strlen($needle)) >= 0 && strpos($haystack, $needle, $temp) !== false);
	}

	//將4000號以內的id轉換成3碼編碼
	public static function createCode($id){
		$_code = dechex($id);
		while(strlen($_code) < 3){
			$_code = '0' . $_code;
		}
		return $_code;
	}

	//序號生成器，需傳入序號前置碼與數量
	public static function createSerials($pre = '' , $qty) {
		$key_sum = $qty * 1.5;    //CD-Key最大数量,防止重复值
 		$key_total = $qty;    //最终需要的CD-Key数量
 		$length = 7;  //生成序號長度

 		/* 生成随机数字串 */
		 $serials = array();
		 for ($i=0; $i<$key_sum; $i++)
		 {
		 	 $serial = '';
		     for ($j=0; $j<$length; $j++){
		     	$serial = $serial . PublicUtil::rdmLetter();
		     }
		     $serials[] = $pre . $serial;
		 }

		  /* 过滤重复串并且提取最终需要的CD-Key数量 */
		 $serials = array_values(array_unique($serials));
		 $serial_result = array();
		 for ($i=0; $i<$key_total; $i++)
		 {
		     $serial_result[] = $serials[$i];
		 }
		 return $serial_result;
	}

	//生成隨機字母
	public static function rdmLetter(){
		$letters = ['0','1','2','3','4','5','6','7','8','9','A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z'];
		 return $letters[(mt_rand(0, count($letters) - 1))];
	}

	/**
	 * 獲取當前控制器與方法
	 *
	 * @return array
	 */
	public static function getCurrentAction()
	{
	    $action = Route::current()->getActionName();
	    list($class, $method) = explode('@', $action);

	    return ['controller' => $class, 'method' => $method];
	}

	/**
	 * 檢查所傳入的Tag陣列有無新的標籤，若有的話進行新增
	 *
	 * @return array
	 */
	public static function chkNewTag($tags)
	{
		foreach ($tags as $key => $value) {
            if (is_null(Tag::where('id',$value)->first())) {
                $newTag = Tag::create(['title' => $value ,'link' => '#' , 'type' => 'def']);
                $tags[$key] = $newTag->id;
            }
        }
        return $tags;
	}




}
