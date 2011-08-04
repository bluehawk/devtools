<h1>I18n Dump</h1>

<?php

foreach ($i18n as $path => $name)
{
	echo "<h3>$path</h3>";
	
	try
	{
		echo Debug::dump(I18n::load($name));
	}
	catch (exception $e)
	{
		echo "Something went terribly wrong. Error message: " . Kohana::exception_text($e);
	}
}
