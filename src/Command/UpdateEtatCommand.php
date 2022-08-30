<?php

namespace App\Command;

use App\Repository\EtatRepository;
use App\Repository\SortieRepository;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class UpdateEtatCommand extends Command
{
    protected static $defaultName = 'app:update-etat';
    protected static $defaultDescription = 'Update l\'état des sorties';

    private $repoSortie;
    private $repoEtat;

    public function __construct(SortieRepository $repoSortie, EtatRepository $repoEtat)
    {
        parent::__construct();
        $this->repoSortie = $repoSortie;
        $this->repoEtat = $repoEtat;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $sorties = $this->repoSortie->findAll();
        $etats = $this->repoEtat->findAll();
        $now = new \DateTime('now');
        $now->modify('+ 2 hours');


        $CREATION = $etats[0];
        $OUVERT = $etats[1];
        $ENCOURS = $etats[2];
        $FERME = $etats[3];
        $PASSE = $etats[4];
        $ARCHIVE = $etats[5];
        $ANNULE = $etats[6];

        foreach ($sorties as $sortie){
            if ($sortie->getEtat()!=$CREATION and $sortie->getEtat()!=$ANNULE){
                if ($sortie->getDateLimiteInscription() < $now){
                    if ($sortie->getDateHeureDebut() > $now){
                        $sortie->setEtat($FERME);
                    } elseif (date_add($sortie->getDateHeureDebut(), \DateInterval::createFromDateString("+".$sortie->getDuree()." minutes")) > $now){
                        $sortie->setEtat($ENCOURS);
                    } elseif (date_add($sortie->getDateHeureDebut(), \DateInterval::createFromDateString("+".$sortie->getDuree()." minutes")) < $now and date_add($sortie->getDateHeureDebut(), \DateInterval::createFromDateString("+1 month")) > $now){
                        $sortie->setEtat($PASSE);
                    } else {
                        $sortie->setEtat($ARCHIVE);
                    }
                } else {
                    dump($sortie->getDateLimiteInscription());
                    $sortie->setEtat($OUVERT);
                }
            }
            $this->repoSortie->add($sortie, true);
        }
        return Command::SUCCESS;
    }
}
