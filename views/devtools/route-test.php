<style type="text/css">
	table.route-test {
		margin-bottom:1.5em;
		background:#eee;
		border:2px solid #ccc;
	}
	
	table.route-test th {
		background:#ddd;
		padding:5px;
	}
	
	table.route-test td {
		padding:2px 10px;
	}
	
	table.route-test .error {
		background:#FFBBBB;
		color:red;
		font-weight:bold;
	}
	
	table.route-test .pass {
		background:#BBFFBB;
		color:green;
	}
</style>

<h1>Route Tester:</h1>

<p>
	<?php echo Form::open() ?>
		<label>Test the url:</label>
		<?php echo Form::input('url',arr::get($_POST,'url'),array('style'=>'width:300px')) ?>
		<?php echo form::submit('test','Test'); ?>
	<?php echo Form::close() ?>
</p>

<?php if (count($tests) == 0): ?>

<p>You can enter a uri to test above, or you can create a config file at <code>config/route-test.php</code> for easy testing of lots of uris.  You can also supply "expected" parameters to quickly test if your routes are functioning like you want them to.  The format for the tests: (as it would appear in a config file:)</p>

<code><pre>return array(

	// Simply dump the route and params for these uris
	'some/url/to/test',
	'another/url',
	'guide/api/Class',
	'guide/media/image.png',
	
	// Test that these uris returns the following route and params
	'guide/media/image.png' = array(
		'route' => 'docs/media',
		'controller' => 'userguide',
		'action' => 'media',
		'file' => 'image.png',
	),
	'blog/5/some-title` = array(
		'route' => 'blog',
		'controller' => 'blog',
		'action' => 'article',
		'id' => '5',
		'title' => 'some-title',
	),
);</pre></code>



<?php else: ?>

	<?php foreach ($tests as $test) :?>
	
	<table class="route-test">
		<tr><th colspan="3">Testing the url "<code><?php echo $test->url ?></code>"</th></tr>
		
		<?php if ($test->route === FALSE): ?>
		
			<tr><td colspan="3" class="error">Did not match any routes</td></tr>
		
		<?php else:?>
		
			<?php if ($test->expected_params): ?>
				
				<tr><th>param</th><th>result</th><th>expected</th>
			
				<?php
				foreach ($test->get_params() as $name => $param)
				{
					echo "<tr><td>{$name}</td><td".($param['error'] ? ' class="error"':' class="pass"').">{$param['result']}</td><td".($param['error'] ? ' class="error"':' class="pass"').">{$param['expected']}</td>";
				}
				?>
				
			<?php else: ?>
			
				<?php foreach ($test->params as $key => $value): ?>
					<tr><td><?php echo $key ?>:</td><td colspan="2"><?php echo $value ?></td></tr>
				<?php endforeach; ?>
				
			<?php endif; ?>
			
		<?php endif; ?>
		
	</table>
	
	<?php endforeach ?>
	
	
	<h2>Copy/paste friendly version:</h2>
	
	<pre style="border:1px dashed #666;padding:10px;" ><?php
	
	foreach ($tests as $test)
	{
	
		echo "Testing the url \"{$test->url}\"\n";
		
		if ($test->route === FALSE)
		{
			echo " ! Did not match any routes\n";
		}
		else
		{
			if ($test->expected_params)
			{
				foreach ($test->get_params() as $name => $param)
				{
					echo ($param['error'] ? ' ✓ ' : ' ! ' ).str_pad(str_pad($name.': ',15).$param['result'].' ',35).'(expecting '.$param['expected'].")\n";
				}
				
			}
			else
			{
				foreach ($test->params as $key => $value)
				{
					echo '   '.str_pad($key.':',15).$value."\n";
				}
			}
		}
		echo "\n";
	}
	?></pre>

<?php endif ?>