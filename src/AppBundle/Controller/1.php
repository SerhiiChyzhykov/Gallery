<?php
if ($_POST["Submit"]){
  //Проверка, действительно ли загруженный файл является изображением
  $imageinfo = getimagesize($_FILES["uploadimg"]["tmp_name"]);
  if($imageinfo["mime"] != "image/gif" && $imageinfo["mime"] != "image/jpeg" && $imageinfo["mime"] !="image/png") {
  print "Загруженный файл не является изображением";die;
  }

  //Сохранение загруженного изображения с расширением, которое возвращает функция getimagesize()
  //Расширение изображения
  $mime=explode("/",$imageinfo["mime"]);
  //Имя файла
  $namefile=explode(".",$_FILES["uploadimg"]["name"]);
  //Полный путь к директории
  $uploaddir = "Z:/home/localhost/www/scripts/upload/";
  //Функция, перемещает файл из временной, в указанную вами папку
  if (move_uploaded_file($_FILES["uploadimg"]["tmp_name"], $uploaddir.$namefile[0].".".$mime[1])) {
    print "Изображение успешно загружено";
  }else{
    print "Произошла ошибка";
  }
}
?>
<form name="upload" enctype="multipart/form-data" action="upload.php" method="post">
  <input type="hidden" name="MAX_FILE_SIZE" value="102400" />
  <input type="file" name="uploadimg" />
  <input type="submit" name="Submit">
</form>
/////////////////////////////////////////////////

  <?php
  // начало сессии и сообщения об ошибках
  session_start();
   
  // вызов файла соединения с базой данных
  require("includes/conn.php");
   
  // Проверка, является ли тип загруженного файла допустимым типом изображения
  function is_valid_type($file)
  {
      // массив, содержащий все допустимые типы файлов изображений
      $valid_types = array("image/jpg","image/jpeg", "image/bmp", "image/gif", "image/png");
   
      if (in_array($file['type'], $valid_types))
          return 1;
      return 0;
  }

  // короткая функция, которая распечатывает содержание массива способом, при котором его легко прочитать
  // можно использовать эту функцию во время отладки, но ей можно пренебречь во время работы скрипта
  function showContents($array)
  {
      echo "
";
      print_r($array);
      echo "
";
  }

  // определение некоторых констант
   
  // в этой переменной - путь к папке изображений, в которой все изображения будут сохраненными
  // обратите внимание на слэш
  $TARGET_PATH = "images/";
   
  // получение отправленных переменных
  $fname = $_POST['fname'];
  $lname = $_POST['lname'];
  $image = $_FILES['image'];
   
  // очистка введённых данных
  $fname = mysql_real_escape_string($fname);
  $lname = mysql_real_escape_string($lname);
  $image['name'] = mysql_real_escape_string($image['name']);
   
  // Построение пути, по которому файл будет перемещен
  // т.e.  images/picture.jpg
  $TARGET_PATH .= $image['name'];
   
  // проверка, заполнены ли все поля формы
  if ( $fname == "" || $lname == "" ||$image['name'] == "" )
  {
      $_SESSION['error'] = "Все поля должны быть заполнены";
      header("Location: index.php");
      exit;
  }
   
  // проверка, является ли загружаемый файл изображением
  // проверяется тип файла, а не расширение, поскольку расширение легко сфальсифицировать
  if (!is_valid_type($image))
  {
      $_SESSION['error'] = "Вы можете загружать файлы jpeg, gif, bmp";
      header("Location: index.php");
      exit;
  }
   
  // проверка, нет ли в базе данных файла с таким же названием
  // устранение проблем с названием с использованием метки времени
  if (file_exists($TARGET_PATH))
  {
      $_SESSION['error'] = "Файл с таким именем уже существует";
      header("Location: index.php");
      exit;
  }
   
  // перемещение файла из временного хранилища в постоянное
  if (move_uploaded_file($image['tmp_name'],$TARGET_PATH))
  {
      // ВНИМАНИЕ: это место, где очень многие делают ошибки
      // мы не вставляем изображение в базу данных; мы вставляем ссылку на расположение файла на сервере
      $sql = "insert into people (fname, lname, filename) values ('$fname', '$lname', '" .$image['name'] . "')";
      $result = mysql_query($sql) or die ("Невозможно вставить данные в базу: " . mysql_error());
      header("Location: images.php");
      exit;
  }
  else
  {
      // частая причина неудачи в продвижении файла в ошибке в правах доступа к директории, нужны права на запись
      // установите для директории права доступа с записью
      $_SESSION['error'] = "Невозможно загрузить файл.  Проверьте права доступа к директории (чтение/запись)";
      header("Location: index.php");
      exit;
  }

  //////////////////////////////////////////////////////////////////
if (Strlen($_POST[`upload`])>0){ 
    if( ($_FILES[`userfile`][`size`] != 0)and 
        ($_FILES[`userfile`][`size`]<(3*1024*1024))){ 

        $imageinfo = getimagesize($_FILES[`userfile`][`tmp_name`]); 
        if ( 
             ($imageinfo[`mime`] == `image/jpeg`)or 
             ($imageinfo[`mime`] == `image/gif`)or 
             ($imageinfo[`mime`] == `image/png`) 
            ) 
        {     
           /*вызываем функцию,(передаем в нее адрес загружаемого изображения и 
           новое место хранения с новым именем файла) которая «подгонит» размер  
           изображения*/         
           big_res($_FILES[`userfile`][`tmp_name`],`etc/image/`.newname.`.jpg`); 
           //Добавляем изображение в базу 
        } 
    }     
}
  //Функция изменения изображения 
function big_res($vvname, $newname) 
{ 
  $max_size = 600; //максимальный размер большей стороны 
  if(file_exists($vvname)){ 
    $infoimg=getimagesize($vvname); 
    switch ( $infoimg[2] ) { 
                         
      case 1: $source = imagecreatefromgif($vvname);$formatimg=".gif"; break; 
      case 2: $source = imagecreatefromjpeg($vvname);$formatimg=".jpg"; break; 
      case 3: $source = imagecreatefrompng($vvname);$formatimg=".png"; break; 
      default: echo "Формат должен быть gif, jpeg, png."; exit; 
    } 
    if (($infoimg[0]<=$max_size)&&($infoimg[1]<=$max_size)){ 
    // если не меняем разрешение то сохраняем  
      $resource = imagecreatetruecolor($infoimg[0], $infoimg[1]); 
      imagecopyresampled($resource, $source, 0, 0, 0, 0,$infoimg[0], $infoimg[1], 
                         $infoimg[0], $infoimg[1]); 
      imagejpeg($resource, $newname, 100); 
      imagedestroy($resource); 
      imagedestroy($source); 
    } 
     else{ 
      // если нужно ресайзитьs 
      $x_vr=$infoimg[0]; 
      $y_vr=$infoimg[1]; 
      if ($x_vr>$y_vr){ 
        $resource = imagecreatetruecolor($max_size, floor(($max_size/$x_vr)*$y_vr)); 
        imagecopyresampled($resource, $source, 0, 0, 0, 0,$x_vr*($max_size/$x_vr), 
        $y_vr*($max_size/$x_vr), $infoimg[0], $infoimg[1];     
      } 
      if ($y_vr>$x_vr){ 
        $resource = imagecreatetruecolor( floor(($max_size/$y_vr)*$x_vr), $max_size); 
        imagecopyresampled($resource, $source, 0, 0, 0, 0,$x_vr*($max_size/$y_vr), 
        $y_vr*($max_size/$y_vr), $infoimg[0], $infoimg[1]); 
      } 
      if ($y_vr==$x_vr){ 
        $resource = imagecreatetruecolor( floor(($max_size/$y_vr)*$x_vr), $max_size); 
        imagecopyresampled($resource, $source, 0, 0, 0, 0,$x_vr*($max_size/$y_vr),  
        $y_vr*($max_size/$y_vr), $infoimg[0], $infoimg[1]); 
      } 
      imagejpeg($resource, $newname, 100); 
      imagedestroy($resource); 
      imagedestroy($source); 
    } 
  }  
}