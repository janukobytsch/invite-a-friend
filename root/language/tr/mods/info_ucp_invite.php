<?php
/**
*
* info_ucp_invite [Turkish]
*
* @author Bycoja bycoja@web.de
* @package language
* @version $Id info_ucp_invite.php 0.6.1 2010-04-05 15:14:09GMT Bycoja $
* @copyright (c) 2010 Bycoja
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
* @translator muiketi - http://www.nethikayesi.com/ - http://www.phpbbturkiye.net/memberlist.php?mode=viewprofile&u=666
*
* Turkish tranlation by:
* muiketi
*/

/**
* DO NOT CHANGE
*/
if (!defined('IN_PHPBB'))
{
	exit;
}

if (empty($lang) || !is_array($lang))
{
	$lang = array();
}

// DEVELOPERS PLEASE NOTE
//
// Placeholders can now contain order information, e.g. instead of
// 'Page %s of %s' you can (and should) write 'Page %1$s of %2$s', this allows
// translators to re-order the output of data while ensuring it remains correct
//
// You do not need this where single placeholders are used, e.g. 'Message %d' is fine
// equally where a string contains only two placeholders which are used to wrap text
// in a url you again do not need to specify an order e.g., 'Click %sHERE%s' is fine

$lang = array_merge($lang, array(
	'UCP_INVITE'					=> 'Arkadaşını davet et',
	'UCP_INVITE_INVITE'				=> 'Davetiye yaz',
	'UCP_INVITE_DESCRIPTION'		=> 'Bu mesaj panosundan haberdar olmasını istediğin arkadaşına e-posta gönder.',
	'REGISTER_KEY'					=> 'Kayıt anahtarı',
	'REGISTER_KEY_EXPLAIN'			=> 'Bu mesaj panosu kullanıcılarından biri tarafından e-posta ile gönderilmiş kod.',

	// Invitation form
	'RECIPIENT_EMAIL'				=> 'Arkadaşınızın e-posta adresi',
	'RECIPIENT_NAME'				=> 'arkadaşınızın adı',
	'MESSAGE_EXPLAIN'				=> 'Arkadaşınıza bu siteyi neden davet etmesini istediğinizi yazın.',
	'SEND_CONFIRM'					=> 'Doğrulama gönder',
	'SEND_CONFIRM_METHOD'			=> 'Doğrulama şekli',
	'INVITATION_ZEBRA'				=> 'Davet edilen kullanıcıyı arkadaş listesine ekle',
	'OPTIONAL'						=> 'İsteğe bağlı',

	// Error messages
	'EMAIL_DISABLED'				=> 'E-posta gönderim özelliği devredışı olduğu için davetiye gönderemezsiniz.',
	'EMAIL_SENT_FAILURE'			=> 'E-posta gönderilirken bir hata oluştu.',
	'EMAIL_SENT_SUCCESS'			=> 'E-postanız arkadışınıza başarıyla gönderildi.',
	'INVITE_DISABLED'				=> 'Davet etme özelliği site yöneticisi tarafından devre dışı bırakıldı.',
	'QUEUE_QUEUE'					=> 'Başka bir arkadaşınıza e-posta gönderebilmek için %d:%02d dakika beklemelisiniz.',
	'INVITATION_LIMIT_DAILY'		=> '%d olan günlük davetiye limitinizi doldurdunuz. Bugün için daha fazla davetiye gönderemezsiniz.',
	'INVITATION_LIMIT_TOTAL'		=> '%d olan toplam davetiye limitinizi doldurdunuz. Daha fazla davetiye gönderemezsiniz.',
	'INVITE_YOURSELF'				=> 'Kendinize yolladığınız kayıt anahtarlarını kullanamazsınız.',
	'INVITE_TO_YOUR_EMAIL'			=> 'Kendinizi davet edemezsiniz.',
	'INVITE_MULTIPLE'				=> 'Girdiğiniz e-posta adresine zaten bir davetiye gönderilmiş.',
	'REGISTER_KEY_INVALID'			=> 'Kayıt anahtarı geçersiz.',
	'REGISTER_KEY_INVALID_OPTIONAL'	=> 'Girdiğiniz kayıt anahtarı geçersiz.',
	'TOO_SHORT_REGISTER_REAL_NAME'	=> 'Girdiğiniz isim çok kısa.',
	'TOO_SHORT_SUBJECT'				=> 'Girdiğiniz mesaj konusu çok kısa.',
	'TOO_SHORT_MESSAGE'				=> 'Girdiğiniz mesaj çok kısa.',
	'TOO_LONG_REGISTER_REAL_NAME'	=> 'Girdiğiniz isim çok uzun.',
	'TOO_LONG_SUBJECT'				=> 'Girdiğiniz mesaj konusu çok uzun.',
	'TOO_LONG_MESSAGE'				=> 'Girdiğiniz mesaj çok uzun.',

	// CAPTCHA
	'POST_CONFIRM_EXPLAIN'			=> 'Otomatik olarak davetiyelerin gönderilmemesi için doğrulama kodunu girmeniz istenmektedir. Eğer doğrulama koduyla ilgili sorun yaşıyorsanız lütfen site yönecisi ile iletişime geçiniz.',

));

?>