<div class="component languages-list-component">
	<ul>
	<?php foreach ($languages as $lang): ?>
		<li><a href="/lang/<?php echo $lang->getCode(); ?>"><?php echo $lang->getName(); ?></a></li>
	<?php endforeach; ?>
	</ul>
</div>
