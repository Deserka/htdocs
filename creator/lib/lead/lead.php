<?php

function __autoload($className)
{
    if (preg_match('/^[a-z][0-9a-z]*(_[0-9a-z]+)*$/i', $className))
    {
        $file = $_SERVER['DOCUMENT_ROOT'] . '/creator/lib/' . str_replace('_' , '/', $className);
        if (file_exists($path = $file . '.php') || file_exists($path = $file . '.class.php'))
        {
            require_once $path;
            return;
        }
    }
    echo "Nie udało się znaleźć ścieżki do pliku klasy " . $className;
}

abstract class Creator {
	
	public function deleteEnters($file) {
	$existedContent = file_get_contents($file);
	$modified = preg_replace("/(^[\r\n]*|[\r\n]+)[\s\t]*[\r\n]+/", "\n", $existedContent);
	$modified = str_replace(PHP_EOL, '', $modified);
	file_put_contents($file, $modified);
	echo "Puste entery usunięto. <br />\n";
	}

	public function startComment($moduleName) {
		return "/* " . $moduleName . " */\n";
	}

	public function endComment($moduleName) {
		return "\n/* End " . $moduleName . " */\n/* Adder */";
	}
	
	public function deleteCommentedByModuleName($moduleName, $file) {
	 	$existedContent = file_get_contents($file);

		if(strpos($existedContent, "/* " . $moduleName . " */") && strpos($existedContent, "/* End " . $moduleName . " */"))
		{
		    $current = preg_replace("/\/\* " . $moduleName . " \*\/(.*)\/\* End " . $moduleName . " \*\//s", "", $existedContent);
			file_put_contents($file, $current);
		    echo "Poprzedni wpis usunięto - " . $moduleName . "<br />\n";
		} else {
			echo "Poprzedni wpis nie istniał - " . $moduleName . "<br />\n";
		}
	}
	
	public function deleteCommentedByModuleNameHTML($moduleName, $file) {
	 	$existedContent = file_get_contents($file);

		if(strpos($existedContent, "<!-- " . $moduleName . " -->") && strpos($existedContent, "<!-- End " . $moduleName . " -->"))
		{
		    $current = preg_replace("/<!-- " . $moduleName . " -->(.*)<!-- End " . $moduleName . " -->/s", "", $existedContent);
			file_put_contents($file, $current);
		    echo "Poprzedni wpis usunięto - " . $moduleName . "<br />\n";
		} else {
			echo "Poprzedni wpis nie istniał - " . $moduleName . "<br />\n";
		}
	}
	
	public function deleteCommentsHTML($file) {
		$existedContent = file_get_contents($file);
		$content = preg_replace('/<!--\*(.*?)\*-->/', '', $existedContent);
		file_put_contents($file, $content);
		echo "Komentarze HTML usunięte. <br />\n";;
		return;
	}
	
	public function saveInExistedFileHTML($content, $file) {
		$existedContent = file_get_contents($file);
		$newContent = str_replace("<!-- Adder -->", $content, $existedContent);
		file_put_contents($file, $newContent);
		echo "Zapisano w pliku: " . $file .". <br />\n";
		return;
	}
	
	public function saveInExistedFile($content, $file) {
		$existedContent = file_get_contents($file);
		$newContent = str_replace("/* Adder */", $content, $existedContent);
		file_put_contents($file, $newContent);
		echo "Zapisano w pliku: " . $file .". <br />\n";
	}
	
	public function imagesAndThumbsCounter(array $images, $thumbPart1=NULL, $thumbPart2=NULL) {
		$count_images = count($images);
		
		if ($thumbPart1 !== NULL && $thumbPart2 !== NULL) {
			for ($i=0; $i<$count_images; $i++) {
				$j = $i+1;
				$temp_name = $thumbPart1 . $j . $thumbPart2;
				if (isset($_POST[$temp_name])) {
					$thumbsAmount = count($_POST[$temp_name]);
				} else {
					$thumbsAmount = 0;
				}
				$array[] = $thumbsAmount;
			}	
		} else {
			$array = NULL;
		}
		return array($count_images, $array);
	}
	// Count editor columns
	public function textColumnCounter($inputName) {
		foreach($inputName as $input) {
			if ($input === 'text') {
				$counter[] = 1;
			}
		}
		if (isset($counter)) {
			$counter = count($counter);
		} else {
			$counter = NULL;
		}
		return $counter;
	}
	
	public function Replacer($what, $forWhat, $where) {
		
	}


}