<h1>Transparent Extension</h1>

<p>Found <?php echo count($classes) ?> classes.</p>

<p>The highest file in the list is the one that takes precedence, the other files are essentially ignored by Kohana.</p>

<?php
foreach ($classes as $key => $value)
{
	$class = substr($key,8,-strlen(EXT));
	$found = Kohana::find_file('classes',$class,NULL,TRUE);
	
	if (count($found) > 1)
	{
		$found = array_reverse($found);
		
		echo "<strong>$key</strong> is being transparently extended:";
		echo "<pre>";
		foreach($found as $path)
		{
			echo "    ".Debug::path($path)."\n";
		}
		echo "</pre>";
	}
}