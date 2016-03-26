<?php
class Mail extends Controller
{
    public function test() {
        $inbox = $this->model('mailM', ['{imap.sfr.fr:993/imap/ssl/novalidate-cert}INBOX', 'louis.gerardd@sfr.fr', 'h5n10j']);
        while ($mail = $inbox->fetch()) {
            $subjectExploded = imap_mime_header_decode($mail['header']->subject);
            $subject = "";
            foreach ($subjectExploded as $part) {
                $subject .= utf8_decode(utf8_encode($part->text));
            }
            echo $subject."<br/>";
        }
    }
}