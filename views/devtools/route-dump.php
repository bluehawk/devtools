<style type="text/css">

table { border-collapse: collapse; width: 100%; border:2px solid #ccc; }
		table th,
		table td { padding: 0.4em; text-align: left; vertical-align: top; }
		table th { width: 12em; }
		table tr:nth-child(odd) { background: #eee; }
		table td.pass { color: #191; }
		table td.fail { color: #911; }
	#results { padding: 0.8em; color: #fff; font-size: 1.5em; }
	#results.pass { background: #191; }
	#results.fail { background: #911; }
	
</style>


<h1>Route Dump</h1>

<?php if (count(Route::all()) > 0): ?>
	
	<?php foreach (Route::all() as $route): ?>
	<h3><?php echo Route::name($route) ?></h3>
		<?php
		$array = (array) $route;
		foreach ($array as $key => $value)
		{
			$new_key = substr($key, strrpos($key, "\x00") + 1);
			$array[$new_key] = $value;
			unset($array[$key]);
		}
		?>
		<table>
			<tr>
				<th>Route uri</th>
				<td><code><?php echo html::chars($array['_uri']) ?></code></td>
			</tr>
			<tr>
				<th>Params with regex</th>
				<td><?php if (count($array['_regex']) == 0) echo "none"; foreach( $array['_regex'] as $param => $regex) echo "<code>\"$param\" = \"$regex\"</code><br/>" ?></td>
			</tr>
			<tr>
				<th>Defaults</th>
				<td><?php if (count($array['_defaults']) == 0) echo "none"; foreach( $array['_defaults'] as $param => $default) echo "<code>\"$param\" = \"$default\"</code><br/>" ?></td>

			</tr>
			<tr>
				<th>Compiled Regex</th>
				<td><code><?php echo html::chars($array['_route_regex']) ?></code></td>
			</tr>
		</table>
	<?php endforeach; ?>
	
<?php else: ?>
<p>No routes</p>
<?php endif; ?>