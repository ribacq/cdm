<div class="component words-list-component">
	<p><?php echo count($words); ?> word(s).</p>
	<ul>
	<?php foreach ($words as $word): ?>
		<li><a href="/word/<?php echo $word->getId(); ?>"><?php echo $word->getOrthography(); ?></a> <?php echo $word->getPronounciation(); ?></li>
	<?php endforeach; ?>
	</ul>
</div>
