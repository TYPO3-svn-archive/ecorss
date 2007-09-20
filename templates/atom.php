<feed xmlns="http://www.w3.org/2005/Atom" xml:lang="<?php $this->printAsText('lang') ?>">
	<title><?php $this->printAsText('title') ?></title>
	<subtitle><?php $this->printAsText('subtitle') ?></subtitle>
	<link rel="alternate" type="text/html" href="<?php $this->printUrl() ?>"/>
	<id><?php print 'http://'.t3lib_div::getIndpEnv('HTTP_HOST');$this->printAsText('url') ?></id>
	<updated><?php print date('c') ?></updated>

	<generator uri="http://typo3.org" version="4.1">TYPO3 - Open Source Content Management</generator>
	<link rel="self" type="application/atom+xml" href="" />
	<?php foreach($this['entries'] as $entry): ?>
	<entry>
		<id><?php $entry->printAsRaw('link')?></id>
		<title><?php $entry->printAsText('title') ?></title>
		<?php if($entry->asRaw('link') != ''): /* check if there is a link to display */ ?>
		<link rel="alternate" type="text/html" href="<?php $entry->printAsRaw('link') ?>"/>
		<?php endif ?>
		<published><?php print date('c',$entry->asText('published')) ?></published>
		<updated><?php print date('c',$entry->asText('updated')) ?></updated>
		<author>
			<name></name>
		</author>
		<summary type="html"><?php $entry->printSummary()?></summary>
	</entry>
	<?php endforeach ?>
</feed>