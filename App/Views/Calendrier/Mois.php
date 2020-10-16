<?php
/*
 * Variables disponibles :
 * $calendar
 * $evenements
 * $idGroupe
 * $moisDemande
 * $employesATrouver
 */
$mois = $calendar->getMonth(new \DateTime($moisDemande->format('Y-m-d')));
$jours = [];
$moisPrecedent = getUrlMois($moisDemande->modify('-1 month'), $idGroupe);
$moisCourant = getUrlMois(new \DateTimeImmutable(), $idGroupe);
$moisSuivant = getUrlMois($moisDemande->modify('+1 month'), $idGroupe);
$timestampMois = $mois->getBegin()->getTimestamp();

require_once VIEW_PATH . 'Calendrier.php';
?>

<div class="btn-group pull-right">
    <a class="btn btn-default" href="<?= $moisPrecedent ?>"><i class="fa fa-chevron-left" aria-hidden="true"></i></a>
    <a class="btn btn-default" title="<?= _('retour_periode_courante') ?>" href="<?= $moisCourant ?>"><i class="fa fa-home" aria-hidden="true"></i></a>
    <a class="btn btn-default" href="<?= $moisSuivant ?>"><i class="fa fa-chevron-right" aria-hidden="true"></i></a>
</div>

<h2><?= date_fr('F', $timestampMois) . ' ' . date('Y', $timestampMois) ?></h2>
<div id="calendrierMois" class="calendrier">
    <table id="calendrier">
        <tr id="entete"><th></th>
            <?php foreach ($mois as $week) : ?>
            <?php foreach ($week as $day) : ?>
            <?php
            $today = ($day->isCurrent()) ? 'today' : '';
            $jourString = $day->getBegin()->format('Y-m-d');
            $jours[] = $jourString;
            ?>
            <th class="<?= $today ?>"><?= $day->getBegin()->format('d') ?></th>
            <?php endforeach ?>
            <?php endforeach ?>
        </tr>
        <?php foreach ($employesATrouver as $loginUtilisation => $nomComplet) : ?>
        <tr class="calendrier-employe">
            <td class="calendrier-nom"><?= $nomComplet ?></td>
            <?php foreach ($jours as $jour) : ?>
            <td class="calendrier-jour <?= getClassesJour($evenements, $loginUtilisation, $jour, $moisDemande) ?>">
                <div class="triangle-top"></div>
                <div class="triangle-bottom"></div>
                <?php $title = getTitleJour($evenements, $loginUtilisation, $jour);
                if (!empty($title)) {
                    echo '<div class="title">' . $title . '</div>';
                }?>
            </td>
            <?php endforeach ?>
        </tr>
        <?php endforeach ?>
    </table>
</div>
<h2>Legende</h2>
<div>
    <table id="legende">
    <tr><td colspan="2"><button onclick="window.location.reload(true)">CLEAR CACHE</button></td></tr>
    <tr><td style="padding:20px"></td></tr>
    <tr><td class="calendrier-jour "></td><td>Jour travaillé</td></tr>
    <tr><td class="calendrier-jour ferie"></td><td>Jour férié</td></tr>
    <tr><td class="calendrier-jour weekend"></td><td>Weekend</td></tr>
    <tr><td></td></tr>
    <tr><td class="calendrier-jour conge_all conge_ok type_1"></td><td>Congé payé</td></tr>
    <tr><td class="calendrier-jour conge_all conge_ok type_2"></td><td>RTT</td></tr>
    <tr><td class="calendrier-jour conge_all conge_ok type_14"></td><td>Sans solde</td></tr>
    <tr><td class="calendrier-jour conge_all conge_ok type_16"></td><td>Télétravail</td></tr>
    <tr><td class="calendrier-jour conge_all conge_ok type_99"></td><td>Autre</td></tr>
    </table>
</div>
