<h1>Message Dump</h1>

<?php

foreach ($messages as $path => $name)
{
	echo "<h3>$path</h3>";
	
	try
	{
		echo Debug::dump(Kohana::message($name));
	}
	catch (exception $e)
	{
		echo "Something went terribly wrong. Error message: " . Kohana::exception_text($e);
	}
}