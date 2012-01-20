<?php
/*
NP_BookmarkButton
ブックマークボタンを表示します。

images/ 内のファイルを nucleus/images/ 以下にコピーして下さい。
*/
class NP_BookmarkButton extends NucleusPlugin {

	function getName() {
		return 'Bookmark Button Plugin';
	}

	function getAuthor() {
		return 'yuuAn';
	}

	function getURL() {
		return 'http://www.yuuan.net/blog/';
	}

	function getVersion() {
		return '0.1';
	}

	function getDescription() {
		return 'ブックマークボタンを設置するためのプラグインです。';
	}

	function install() {
		$this->createOption('MixiKey', 'mixi check key', 'text', '');
	}

	function doTemplateVar($item, $type) {
		global $blog;
		$itemurl = $blog->settings['burl'] . createItemLink($item->itemid);
		$itemurl_enc = rawurlencode($itemurl);
		$blogid = getBlogIDFromItemID($item->itemid);
		$itemtitle = getBlogNameFromID($blogid) . " / " . $item->title;
		$itemtitle_enc = rawurlencode($itemtitle);
		$type = preg_replace('/[\'\"]/', '', $type);

		$html = '';
		switch ($type) {
			case "hatena":
				$hatena_img_url = './nucleus/images/hatena_bookmark.png';
				$html = <<<HTML_HATENA
    <!-- Hatena Bookmark -->
    <a class="vtip" href="http://b.hatena.ne.jp/add?mode=confirm&title={$itemtitle_enc}&url={$itemurl_enc}" class="hatena-bookmark-button" data-hatena-bookmark-layout="simple" title="このエントリーをはてなブックマークに追加">
        <img src="{$hatena_img_url}" alt="このエントリーをはてなブックマークに追加" width="20" height="20" style="border: none;" />
    </a>
    <script type="text/javascript" src="http://b.st-hatena.com/js/bookmark_button.js" charset="utf-8" async="async"></script>
HTML_HATENA;
				break;

			case "twitter":
				$twitter_img_url = './nucleus/images/tweet.png';
				$html = <<<HTML_TWITTER
    <!-- Twitter -->
    <a class="vtip" href="http://twitter.com/share?count=horizontal&amp;original_referer={$itemurl_enc}&amp;text={$itemtitle_enc}&amp;url={$itemurl_enc}" onclick="window.open(this.href, 'tweetwindow', 'width=550,height=450,personalbar=0,toolbar=0,scrollbars=1,resizable=1'); return false;" title="このエントリーをTwitterで共有">
        <img src="{$twitter_img_url}" width="20" height="20" />
    </a>
HTML_TWITTER;
				break;

			case "mixi":
				$mixi_img_url = './nucleus/images/mixi_check.png';
				$key = $this->getOption('MixiKey');
				$html = <<<HTML_MIXI
    <!-- mixi check -->
    <a class="vtip" href="javascript:void(0);" onclick="window.open('http://mixi.jp/share.pl?u={$itemurl_enc}&k={$key}','share',['width=632','height=456','location=yes','resizable=yes','toolbar=no','menubar=no','scrollbars=no','status=no'].join(','));" title="このエントリーをmixiチェックする">
        <img src="{$mixi_img_url}" width="20" height="20" />
    </a>
HTML_MIXI;
				break;

			case "facebook":
				$facebook_img_url = './nucleus/images/facebook.png';
			$html = <<<HTML_FACEBOOK
    <!-- Facebook -->
    <a class="vtip" href="http://www.facebook.com/share.php?u={$itemurl_enc}" onclick="window.open(this.href,'facebookwindow','width=550,height=450,personalbar=0,toolbar=0,scrollbars=1,resizable=1'); return false;" title="このエントリーをFacebookで共有">
        <img src="{$facebook_img_url}" width="20" height="20" />
    </a>
HTML_FACEBOOK;
				break;
		}
		echo $html;
	}

	function supportsFeature ($what) {
		switch ($what) {
			case 'SqlTablePrefix':
				return 1;
			case 'SqlApi':
				return 1;
			default:
				return 0;
		}
	}
}
?>