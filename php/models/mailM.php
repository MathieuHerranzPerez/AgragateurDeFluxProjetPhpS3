<?php
class MailM
{
    private $connexion;
    private $inbox = [];
    private $i = 0;

    public function __construct($server, $mail, $pass)
    {
        /* EXEMPLE
        server : {imap.gmail.com:993/imap/ssl}INBOX
        mail : test@gmail.com
        pass : test
        */
        $this->connexion = imap_open($server, $mail, $pass);
        $nbMails = imap_num_msg($this->connexion);
        for ($i = 1; $i <= $nbMails; ++$i) {
            //objet
            $header = imap_rfc822_parse_headers(imap_fetchbody($this->connexion, $i, 0));
            $headerExploded = imap_mime_header_decode($header->subject);
            $subject = "";
            foreach ($headerExploded as $part) {
                $subject .= imap_utf8($part->text);
            }
            array_push($this->inbox,
                ['objet' => $subject,
                'auteur' => $header->from[0]->mailbox,
                'contenu' => htmlspecialchars(quoted_printable_decode(imap_fetchbody($this->connexion, $i, 1.1))),
                'struct' => imap_fetchstructure($this->connexion, $i),
                'date' => $header->date]);
        }
        imap_close($this->connexion);
    }

    public function fetch() {
        if ($this->i < count($this->inbox))
            return $this->inbox[$this->i++];
        else
            return false;
    }
}