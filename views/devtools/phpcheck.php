<style type="text/css">

table { border-collapse: collapse; width: 100%; border:2px solid #ccc; margin: 10px 0px; }
		table th,
		table td { padding: 0.4em; text-align: left; vertical-align: top; }
		table th { width: 12em; }
		table th.prefix { color: #FF9900; }
		table th.suffix { color: #0000FF; }
		table tr:nth-child(odd) { background: #eee; }
		table td.pass { color: #191; }
		table td.fail { color: #911; }
	#results { padding: 0.8em; color: #fff; font-size: 1.5em; }
	#results.pass { background: #191; }
	#results.fail { background: #911; }
	
</style>


<h1>PHP Check</h1>


<?php 
//debug($phpfiles, true);

function list_phpfiles($value, $key, $result)
{
//	debug($key);
//	debug($value);
	if(stripos($key, '.php'))
		$result[$key] = $value;
}	 

$result = array();
array_walk_recursive($class_files, 'list_phpfiles', &$result);
//debug($result);

?>
<?php
foreach ($result as $path => $abs_filename)
{
//	echo "<h3>$path</h3>";
	try
	{
		$content = file_get_contents($abs_filename);
		$rel_filename = str_replace(DOCROOT, "", $abs_filename);

		$prefix_pattern = '/^[\t\s]+<\?php/';
		$prefix_match_found = preg_match($prefix_pattern, $content, $prefix_matches);
		
		$suffix_pattern = '/\?>$/';
		$suffix_match_found = preg_match($suffix_pattern, $content, $suffix_matches);

		?>
		<?php if($prefix_match_found || $suffix_match_found) :?>
			<table>
				<tr>
					<th>URI</th>
					<td><code><?php echo html::chars($path) ?></code></td>
				</tr>
				<tr>
					<th>File Location</th>
					<td><code><?php echo html::chars($rel_filename) ?></code></td>
				</tr>
				
				<?php if($prefix_match_found > 0) : ?>
				<tr>
					<th class='prefix'>Prefix Problem</th>
					<td><?php 	foreach( $prefix_matches as $key => $value)
									echo "<code>Found \"".html::chars($value)."\"</code><br/>"
						?>
					</td>
				</tr>
				<?php endif ?>
				
				<?php if($suffix_match_found > 0) : ?>
				<tr>
					<th class='suffix'>Suffix Problem</th>
					<td><?php 	foreach( $suffix_matches as $key => $value)
									echo "<code>Found \"".html::chars($value)."\"</code><br/>"
						?>
					</td>
				</tr>
				<?php endif ?>
			</table>
		<?php endif ?>
		<?php 

	}
	catch (exception $e)
	{
		echo "Something went terribly wrong. Error message: " . Kohana::exception_text($e);
	}
}

?>
