<feed xmlns="http://www.w3.org/2005/Atom" xml:lang="<?php $this->printAsText('lang') ?>">
	<title><?php $this->printAsText('title') ?></title>
	<subtitle><?php $this->printAsText('subtitle') ?></subtitle>
	<link rel="alternate" type="text/html" href="<?php $this->printAsText('url') ?>"/>
	<id><?php $this->printUrl() ?></id>
	<updated><?php print date('c') ?></updated>

	<generator uri="http://typo3.org" version="<?php echo t3lib_div::int_from_ver($GLOBALS['TYPO_VERSION']); ?>">TYPO3 - Open Source Content Management</generator>
	<link rel="self" type="application/atom+xml" href="<?php $this->printUrl() ?>" />
	<?php foreach($this['entries'] as $entry): ?>
	<entry>
		<id><?php print htmlspecialchars($entry->asRaw('link')) ?></id>
		<title><?php $entry->printAsText('title') ?></title>
		<?php if($entry->asRaw('link') != ''): /* check if there is a link to display */ ?>
		<link rel="alternate" type="text/html" href="<?php print htmlspecialchars($entry->asRaw('link')) ?>"/>
		<?php endif ?>
		<published><?php print date('c',$entry->asText('published')) ?></published>
		<updated><?php print date('c',$entry->asText('updated')) ?></updated>
		<author>
			<name><?php print $entry->asText('author') ?></name>
		</author>
		<summary type="html"><?php $entry->printSummary()?></summary>
	</entry>
	<?php endforeach ?>
</feed>
