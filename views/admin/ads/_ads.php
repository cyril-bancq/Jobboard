<form action="" method="POST">
            <?= $form->input('title', 'Title :'); ?>
            <?= $form->input('date', 'Creation Date :'); ?>
            <?= $form->input('salary', 'Salary :'); ?>
            <?= $form->input('duration', 'Duration :'); ?>
            <?= $form->input('hour', 'Number of hour :'); ?>
            <?= $form->input('contract', 'Type of Contract :'); ?>
            <?= $form->textarea('description', 'Description :'); ?>
            <button class="btn btn-primary mt-2" onclick="return confirm('Do you really want to edit the advertissement')">
            <?php if ($ads->getID() !== null) : ?>
                Edit   
            <?php else : ?>
                Create
            <?php endif ?></button>
</form>