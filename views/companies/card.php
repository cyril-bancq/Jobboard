<div class="card" style="border: 2px solid #008dd5">
<div class="text-center">
  <div class="card-header" style="background-color: #008dd5; color: white">Companies #<?= htmlentities($companie->getId()) ?></div>
</div>
  <div class="card-body">
    <h5 class="card-title"><?= $companie->getName() ?></h5>
    <p class="card-text">Activities : <?= $companie->getActivities() ?></p>
    <p class="card-text">Email : <?= $companie->getEmail() ?></p>
    <p class="card-text">Phone : <?= $companie->getPhone() ?></p>
    <p class="card-text">Location : <?= $companie->getAddress() . "-" . $companie->getPostalCode() . "-" . $companie->getCity()?></p>
    <p class="card-text">SIRET : <?= $companie->getSiret() ?></p>
    <p class="card-text">Number of employes : <?= $companie->getNumberEmployes() ?></p>
    <p class="card-text">Contact : <?= $companie->getContactName() ?></p>
  </div>
  <div class="card-footer">
    <div class="text-center">
        <p class="card-text">Website : <?= $companie->getWebsite() ?></p>
    </div>
  </div>
</div>