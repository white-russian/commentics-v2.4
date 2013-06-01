<?php
/*
Copyright © 2009-2013 Commentics Development Team [commentics.org]
License: GNU General Public License v3.0
		 http://www.commentics.org/license/

This file is part of Commentics.

Commentics is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

Commentics is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with Commentics. If not, see <http://www.gnu.org/licenses/>.

Text to help preserve UTF-8 file encoding: 汉语漢語.
*/

if (!defined('IN_COMMENTICS')) { die('Access Denied.'); }

define('CMTX_DESC_LAYOUT_ORDER_1', 'Arraste e solte os elementos abaixo para determinar a ordem de classificação das partes principais.');
define('CMTX_DESC_LAYOUT_ORDER_2', 'Split the screen into a side-by-side layout. You will need the width to do this.');
define('CMTX_DESC_LAYOUT_COMMENTS_ENABLED', 'Estas configurações determinam que partes dos comentários e suas áreas externas estarão habilitados.');
define('CMTX_DESC_LAYOUT_COMMENTS_GENERAL', 'Esta seção contém configurações gerais dos comentários.');
define('CMTX_DESC_LAYOUT_COMMENTS_PAGINATION', 'Estas configurações são relacionadas ao layout da paginação.');
define('CMTX_DESC_LAYOUT_COMMENTS_SORT_BY_1', 'Esta configuração determina se o Sort By recurso está ativado.');
define('CMTX_DESC_LAYOUT_COMMENTS_SORT_BY_2', 'Estas configurações são para controlar quais links são habilitados.');
define('CMTX_DESC_LAYOUT_COMMENTS_REPLIES', 'Estas configurações são para a funcionalidade de responder.');
define('CMTX_DESC_LAYOUT_COMMENTS_SOCIAL_1', 'Estas configurações são para os links sociais.');
define('CMTX_DESC_LAYOUT_COMMENTS_SOCIAL_2', 'Estas configurações são para controlar quais links são habilitados.');
define('CMTX_DESC_LAYOUT_COMMENTS_GRAVATAR', 'A <b>Gravatar</b> é uma imagem de usuário\'s pessoais, hospedado no gravatar.com, que está recuperado de acordo com seu endereço de email fornecido.<p/>Se o usuário não tem um Gravatar, então o padrão um é exibido. Veja <a href="http://en.gravatar.com/site/implement/images/" target="_blank">aqui</a> para as possíveis opções abaixo.');
define('CMTX_DESC_LAYOUT_COMMENTS_READ_MORE', 'Estas configurações são para os link Leia Mais.');
define('CMTX_DESC_LAYOUT_FORM_ENABLED', 'Estas configurações determinam quais partes do formulário são habilitadas.');
define('CMTX_DESC_LAYOUT_FORM_REQUIRED', 'Estas configurações determinam quais partes do formulário são requeridas.');
define('CMTX_DESC_LAYOUT_FORM_DEFAULTS', 'Esta seção permite que valores padrão sejam configurados.');
define('CMTX_DESC_LAYOUT_FORM_GENERAL', 'Esta seção contém configurações gerais dos formulários.');
define('CMTX_DESC_LAYOUT_FORM_MAXIMUMS', 'These settings determine the maximum lengths.');
define('CMTX_DESC_LAYOUT_FORM_SORT_ORDER_FIELDS', 'Arraste e solte os elementos abaixo para determinar a ordem dos campos no formulário.');
define('CMTX_DESC_LAYOUT_FORM_SORT_ORDER_BUTTONS', 'Arraste e solte os elementos abaixo para determinar a ordem dos botões no formulário.');
define('CMTX_DESC_LAYOUT_FORM_BB_CODE', 'Estas configurações são para as tags de BB Code no formulário.');
define('CMTX_DESC_LAYOUT_FORM_SMILIES', 'Estas configurações são para as imagens de emoticons no formulário.');
define('CMTX_DESC_LAYOUT_POWERED', 'Estas configurações são para o descritivo de \'Powered by\'.');
define('CMTX_DESC_SETTINGS_ADMIN', 'Estas configurações são para o painel de administrador.');
define('CMTX_DESC_SETTINGS_ADMIN_DETECTION', 'Esta seção permite a detecção do administrador.');
define('CMTX_DESC_SETTINGS_AKISMET', 'Akismet é um serviço gratuito externo automatizado usado para identificar comentários como spam. Obter a sua chave API <a href="http://akismet.com/" target="_blank">aqui</a>.<p/>Comentários identificados necessitam de aprovação. O \'Akismet\' palavra aparecerá na seção de comentários do Notes.');
define('CMTX_DESC_SETTINGS_APPROVAL', 'Selecione estes se você quer <i>manualmente</i> aprovar os dados abaixo.<p /><b>Obs</b>: Opções detalhadas estão em Configurações -> Processador.');
define('CMTX_DESC_SETTINGS_EMAIL_SETUP', 'Set up your email settings and preferences here.');
define('CMTX_DESC_SETTINGS_EMAIL_METHOD', 'Selecione o método de envio de email.');
define('CMTX_DESC_SETTINGS_EMAIL_SENDER', 'Change your sender details here to update <b>all</b> the emails.<p />Or use the \'Settings -> Email -> Editor\' to do it individually.');
define('CMTX_DESC_SETTINGS_EMAIL_SIGNATURE', 'This is your signature for the emails.');
define('CMTX_DESC_SETTINGS_EMAIL_TEST', 'Send an email to test your email settings and preferences.<p />The email will be sent to <b>%s</b>.');
define('CMTX_DESC_SETTINGS_EMAIL_SUB_CONFIRMATION', 'Este é o email de confirmação que o usuário recebe quando se inscreve em uma página.');
define('CMTX_DESC_SETTINGS_EMAIL_SUB_NOTIFICATION', 'Este é o email que o usuário recebe quando ele é notificado de um novo comentário.');
define('CMTX_DESC_SETTINGS_EMAIL_EMAIL_TEST', 'This is the email sent from the \'Settings -> Email -> Setup\' page.');
define('CMTX_DESC_SETTINGS_EMAIL_NEW_BAN', 'Este é o email que o administrador recebe quando há um novo banimento.');
define('CMTX_DESC_SETTINGS_EMAIL_NEW_COMMENT_APPROVE', 'Este é o email que o administrador recebe quando um novo comentário necessita de aprovação.');
define('CMTX_DESC_SETTINGS_EMAIL_NEW_COMMENT_OKAY', 'Este é o email que o administrador recebe quando um novo comentário está ok.');
define('CMTX_DESC_SETTINGS_EMAIL_NEW_FLAG', 'Este é o email que o administrador recebe quando um novo comentário é marcado.');
define('CMTX_DESC_SETTINGS_EMAIL_RESET_PASSWORD', 'Este é o email que o administrador recebe quando está resetando a senha.');
define('CMTX_DESC_SETTINGS_ERROR_REPORTING', 'Habilite estas configurações para produzir qualquer erro possível. Útil para depurar.');
define('CMTX_DESC_SETTINGS_FLAGGING', 'Estas configurações são relativas a funcionalidade de marcar / relatar.');
define('CMTX_DESC_SETTINGS_FLOODING', 'Estas configurações são relativas ao envio de múltiplos comentários em um período curto de tempo.');
define('CMTX_DESC_SETTINGS_LANGUAGE', 'Selecione o idioma desejado para as páginas.');
define('CMTX_DESC_SETTINGS_MAINTENANCE', 'Habilite esta configuração para colocar o script em modo de manutenção. Útil durante atualizações.<p /><b>Obs</b>: O administrador é excluído do modo de manutenção.');
define('CMTX_DESC_SETTINGS_PROCESSING_NAME', 'Estas configurações são relativas ao processamento do campo Nome.');
define('CMTX_DESC_SETTINGS_PROCESSING_EMAIL', 'Estas configurações são relativas ao processamento do campo Email.');
define('CMTX_DESC_SETTINGS_PROCESSING_TOWN', 'Estas configurações são relativas ao processamento do campo Cidade.');
define('CMTX_DESC_SETTINGS_PROCESSING_WEBSITE', 'Estas configurações são relativas ao processamento do campo Website.');
define('CMTX_DESC_SETTINGS_PROCESSING_COMMENT', 'Estas configurações são relativas ao processamento do campo Comentário.');
define('CMTX_DESC_WILDCARDS', 'Wildcard symbols <b>are</b> supported. Searches are case-insensitive.');
define('CMTX_DESC_WILDCARDS_1', 'By using the wildcard symbol (*), you can match any characters. For example the user enters the word "<b>Newcastle</b>". The following cases would give these results:');
define('CMTX_DESC_WILDCARDS_2', 'The searches are case-insensitive, so for example the word "<b>Newcastle</b>" could be matched by Newcastle, newcastle, or even nEwCaStLe.');
define('CMTX_DESC_WILDCARDS_3', 'Each word should be on a new line. Empty lines are ignored.');
define('CMTX_DESC_WILDCARDS_A', 'Although the wildcard symbol (*) is supported, it is not necessary here. For example the user enters the email address "<b>test@somesite.com</b>". The following cases would give these results:');
define('CMTX_DESC_WILDCARDS_B', 'The searches are case-insensitive, so for example the email address "<b>test@somesite.com</b>" could be matched by somesite, SOMESITE, or even SoMeSiTe.');
define('CMTX_DESC_WILDCARDS_C', 'Each case should be on a new line. Empty lines are ignored.');
define('CMTX_DESC_WILDCARDS_I', 'Although the wildcard symbol (*) is supported, it is not necessary here. For example the user enters the website address "<b>http://www.somesite.com</b>". The following cases would give these results:');
define('CMTX_DESC_WILDCARDS_II', 'The searches are case-insensitive, so for example the website address "<b>http://www.somesite.com</b>" could be matched by somesite, SOMESITE, or even SoMeSiTe.');
define('CMTX_DESC_WILDCARDS_III', 'Each case should be on a new line. Empty lines are ignored.');
define('CMTX_DESC_WILDCARD_FOUND', '(Found)');
define('CMTX_DESC_WILDCARD_NOT_FOUND', '(Not found)');
define('CMTX_DESC_SETTINGS_RECAPTCHA', 'ReCaptcha é um serviço de imagem gratuito e externo Captcha para evitar spam.<p/>É seguro, amplamente utilizado, e ajuda a digitalizar livros. Receba as chaves da API <a href="http://www.google.com/recaptcha" target="_blank">aqui</a>.');
define('CMTX_DESC_SETTINGS_RICH_SNIPPETS_1', '<b>Rich Snippets</b> is a way of marking-up certain types of data so that it appears in a specially displayed format in the search engine results pages, making it easier for users to decide whether to click to your site.<p />In Commentics the type of data which is marked-up is the <b>average rating</b>. It can be marked-up with any of 3 formats: Microdata, Microformats or RDFa. I recommend <b>Microformats</b> because it uses valid xHTML.<p />This is an example of how this feature looks:');
define('CMTX_DESC_SETTINGS_RICH_SNIPPETS_2', 'To use this feature, both the <b>Average Rating</b> (Layout -> Comments -> Enabled) and the <b>Topic</b> (Layout -> Comments -> Enabled) must also be enabled.<p />After you have enabled this feature, you can test it <a href="http://www.google.com/webmasters/tools/richsnippets" target="_blank">here</a>. You must have at least one rating for the mark-up to be added.');
define('CMTX_DESC_SETTINGS_RSS', 'Estas configurações são relativas ao feed RSS de comentários.');
define('CMTX_DESC_SETTINGS_SECURITY', 'Estas configurações são relativas a segurança do script.');
define('CMTX_DESC_SETTINGS_SYSTEM', 'Estas configurações são relativas ao sistema. Seja cuidadoso ao mudá-las.');
define('CMTX_DESC_SETTINGS_VIEWERS', 'Estas configurações se relacionam com o recurso Reports -> Viewers.');
define('CMTX_DESC_TASK_DELETE_BANS', 'Esta tarefa automaticamente exclui banidos que são mais velhos que o período de tempo configurado.');
define('CMTX_DESC_TASK_DELETE_REPORTERS', 'Esta tarefa automaticamente exclui relatórios que são mais velhos que o período de tempo configurado.');
define('CMTX_DESC_TASK_DELETE_SUBSCRIBERS', 'Esta tarefa automaticamente exclui inscritos que continuam sem confirmar por mais tempo que o período de tempo configurado.');
define('CMTX_DESC_TASK_DELETE_VOTERS', 'Esta tarefa automaticamente exclui eleitores que são mais velhos que o período de tempo configurado.');
define('CMTX_DESC_REPORT_ACCESS', 'Este relatório mostra as últimas 100 páginas que o(s) administrador(es) viram.');
define('CMTX_DESC_REPORT_PERMISSIONS', 'Este relatório checa se as permissões de suas pastas e arquivos estão corretamente configuradas:');
define('CMTX_DESC_REPORT_VERSION_1', 'A versão instalada do Commentics é a');
define('CMTX_DESC_REPORT_VERSION_2', 'Abaixo está um histórico de suas atualizações.');
define('CMTX_DESC_REPORT_VIEWERS', 'As seguintes pessoas ou robôs de mecanismo de busca estão atualmente vendo sua(s) página(s).');
define('CMTX_DESC_TOOL_DATABASE_BACKUP', 'Criar um backup da sua base de dados.<p/><b>Obs</b>: É extremamente recomendado que voc:e baixe estes backups para seu computador.');
define('CMTX_DESC_TOOL_OPTIMIZE_TABLES', 'Esta ferramenta irá otimizar todas as tabelas da sua base de dados. Isto acelera o tempo de resposta da base de dados e ajuda a evitar dados corrompidos.<p/><b>Obs</b>: Para um site normal, executar esta ferramenta a cada 2 semanas deve ser o suficiente.');
define('CMTX_DESC_TOOL_TEXT_FINDER', 'Search the language files for a specific word (or phrase).');

?>