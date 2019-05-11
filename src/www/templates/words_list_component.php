<div class="component words-list-component">
	<h2>New word</h2>
	<?php $word = new Word($language, ''); include('word_edit_component.php'); ?>
	<h2><?php echo count($words); ?> word(s).</h2>
	<?php foreach ($words as $word): ?>
		<p><a href="/word/<?php echo $word->getId(); ?>"><?php echo $word->getOrthography(); ?></a> <?php echo $word->getPronounciation(); ?></p>
		<?php include('word_edit_component.php'); ?>
	<?php endforeach; ?>
</div>
