<!-- Заголовок страницы -->
<div class="row mb-4">
    <div class="col-12">
        <h1 class="display-4">Ласкаво просимо до Employee Management System</h1>
        <p class="lead">Система управління співробітниками та департаментами</p>
    </div>
</div>

<!-- Карточки со статистикой -->
<div class="row mb-5">
    <div class="col-md-6">
        <div class="card text-white bg-primary">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h5 class="card-title">Департаментами</h5>
                        <h2 class="card-text"><?php echo $totalDepartments ?? 0; ?></h2>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-building fa-2x"></i>
                    </div>
                </div>
                <a href="/departments" class="btn btn-light mt-2">Управління департаментами</a>
            </div>
        </div>
    </div>
    
    <div class="col-md-6">
        <div class="card text-white bg-success">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h5 class="card-title">Співробітники</h5>
                        <h2 class="card-text"><?php echo $totalUsers ?? 0; ?></h2>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-users fa-2x"></i>
                    </div>
                </div>
                <a href="/users" class="btn btn-light mt-2">Управління співробітниками</a>
            </div>
        </div>
    </div>
</div>

<!-- Последние добавленные департаменты -->
<div class="row mb-4">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Останні департаменти</h5>
                <a href="/departments" class="btn btn-sm btn-outline-primary">Усі департаменти</a>
            </div>
            <div class="card-body">
                <?php if (!empty($recentDepartments)): ?>
                    <div class="list-group list-group-flush">
                        <?php foreach ($recentDepartments as $department): ?>
                            <div class="list-group-item d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="mb-1"><?php echo htmlspecialchars($department['name']); ?></h6>
                                    <small class="text-muted"><?php echo htmlspecialchars($department['description'] ?? ''); ?></small>
                                </div>
                                <small class="text-muted"><?php echo date('d.m.Y', strtotime($department['created_at'])); ?></small>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <p class="text-muted">Департаментів не знайдено</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
    
    <!-- Последние добавленные сотрудники -->
    <div class="col-md-6">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Останні співробітники</h5>
                <a href="/users" class="btn btn-sm btn-outline-success">Усі співробітники</a>
            </div>
            <div class="card-body">
                <?php if (!empty($recentUsers)): ?>
                    <div class="list-group list-group-flush">
                        <?php foreach ($recentUsers as $user): ?>
                            <div class="list-group-item d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="mb-1"><?php echo htmlspecialchars($user['name'] ); ?></h6>
                                    <small class="text-muted"><?php echo htmlspecialchars($user['position'] ?? ''); ?></small>
                                </div>
                                <small class="text-muted"><?php echo date('d.m.Y', strtotime($user['created_at'])); ?></small>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <p class="text-muted">Співробітників не знайдено</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- Быстрые действия -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Швидкі дії</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3 mb-2">
                        <a href="/departments/create" class="btn btn-primary w-100">
                            <i class="fas fa-plus"></i> Додати департамент
                        </a>
                    </div>
                    <div class="col-md-3 mb-2">
                        <a href="/users/create" class="btn btn-success w-100">
                            <i class="fas fa-user-plus"></i> Додати співробітника
                        </a>
                    </div>
                    <div class="col-md-3 mb-2">
                        <a href="/departments" class="btn btn-info w-100">
                            <i class="fas fa-list"></i> Список департаментів
                        </a>
                    </div>
                    <div class="col-md-3 mb-2">
                        <a href="/users" class="btn btn-warning w-100">
                            <i class="fas fa-users"></i> Список співробітників
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Дополнительные стили для иконок -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">