<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Редактировать отдел</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group me-2">
            <a href="/departments/<?= $department['id'] ?>" class="btn btn-sm btn-outline-info">
                <i class="bi bi-eye"></i> Просмотр
            </a>
            <a href="/departments" class="btn btn-sm btn-outline-secondary">
                <i class="bi bi-arrow-left"></i> Назад к списку
            </a>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-body">
                <form method="POST" action="/departments/<?= $department['id'] ?>">
                    <input type="hidden" name="_method" value="PUT">
                    
                    <div class="mb-3">
                        <label for="name" class="form-label">Название отдела *</label>
                        <input type="text" class="form-control <?= isset($errors['name']) ? 'is-invalid' : '' ?>" 
                               id="name" name="name" value="<?= htmlspecialchars($old['name'] ?? $department['name']) ?>" required>
                        <?php if (isset($errors['name'])): ?>
                            <div class="invalid-feedback"><?= $errors['name'] ?></div>
                        <?php endif; ?>
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Описание</label>
                        <textarea class="form-control <?= isset($errors['description']) ? 'is-invalid' : '' ?>" 
                                  id="description" name="description" rows="3"><?= htmlspecialchars($old['description'] ?? $department['description']) ?></textarea>
                        <?php if (isset($errors['description'])): ?>
                            <div class="invalid-feedback"><?= $errors['description'] ?></div>
                        <?php endif; ?>
                    </div>

                    <div class="mb-3">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save"></i> Сохранить изменения
                        </button>
                        <a href="/departments/<?= $department['id'] ?>" class="btn btn-secondary">
                            <i class="bi bi-x-circle"></i> Отмена
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>