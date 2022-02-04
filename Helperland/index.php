<?php

$controller = "Public";
$function = "home";
$parameter = '';

if(isset($_GET['controller']) && $_GET['controller'] != ''){
	$controller = $_GET['controller'];
}

if(isset($_GET['function']) && $_GET['function'] != ''){
	$function = $_GET['function'];
}

if(isset($_GET['parameter']) && $_GET['parameter'] != ''){
	$parameter = $_GET['parameter'];
}
if(file_exists('controllers/'.$controller.'Controller.php')){
	include('controllers/'.$controller.'Controller.php');
	$class = $controller.'Controller';
	$obj = new $class();
	if(method_exists($class,$function)){
		if($parameter){
			$obj->$function($parameter);
		}
		else{
			$obj->$function();
		}
	}
	else{
		echo "Function not found";
	}
}
else{
	echo "Controller Not Found";
}
?>