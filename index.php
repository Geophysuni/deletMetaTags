<?php

// загружаем страницу как строку
$html = file_get_contents('index_initial.html');

// отмечаем желаемый элемент
$substring = "<meta";


// собираем в вектор индексы начала тега
$lastPos = 0;
$startpositions = array();
$endpositions = array();

while (($lastPos = strpos($html, $substring, $lastPos))!== false) {
    $startpositions[] = $lastPos;
    $lastPos = $lastPos + strlen($substring);
}



// собираем в вектор индексы конца тега
foreach ($startpositions as $value) {
    // echo substr($html, $value, 10);
    for ($i = $value; $i < $value+300; $i++) {
        // echo $html[$i];
        if($html[$i]==='>'){
            array_push($endpositions, $i+1);
            break;
        }
    }  

}


// собираем вектор с индексами, которые относятся к тегам
$exclude = array();
for ($i = 0; $i < count($startpositions); $i++){
    for($j=$startpositions[$i];$j<$endpositions[$i];$j++){
        array_push($exclude,$j);
    }
}

// инициализируем новую строку и добавляем все индексы из исходной, которые не попадают в список исключений
$newHtml = "";
for ($i = 0; $i < strlen($html); $i++){
    if(!in_array($i,$exclude)){
        // echo $i;
        $newHtml = $newHtml.$html[$i];
    }
}

// сохраняем новую страницу без тегов
file_put_contents("newHtml.html", $newHtml);

?>