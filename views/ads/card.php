<div class="text-center">
        <div class="ads mt-3">
            <div class="card">
                <h5 class="card-header">Job advertissement #<?= htmlentities($ad->getID()) ?></h5>
                <div class="card-body">
                    <div class="card-title"><?= $ad->getTitle() ?></div>
                    <div class="card-text"><?= $ad->getExcerpt() ?></p>
                    <a href="<?= $router->url('post', ['id' => $ad->getID(), 'slug' => $ad->getTitle()]) ?>" class="btn btn-primary">Learn More</a>
                    <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#exampleModal" data-bs-whatever="apply">Apply</button>
                </div>
            </div>
                <div class="card-footer text-muted"><?= $ad->getDate()->format('d F Y') ?></div>
        </div>
    </div>
</div>

<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Apply for <?= $ad->getTitle() ?></h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <form action="" method="POST">
            <div class="mb-3">
                <?= $form->textarea('motivation_people', 'Motivation :'); ?>
                <?= $form->input('people_id', 'User :') ?>
                <?= $form->input('advertissement_id', 'Advertissement :') ?>
            </div>
            <button type="submit" class="btn btn-primary">Send</button>
            </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
        </div>
    </div>
</div>

<script>
    var exampleModal = document.getElementById('exampleModal')
    exampleModal.addEventListener('show.bs.modal', function (event) {
        var button = event.relatedTarget
        var recipient = button.getAttribute('data-bs-whatever')
    })
</script>