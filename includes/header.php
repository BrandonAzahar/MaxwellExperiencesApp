<?php
/**
 * Header Común del Sistema
 * Maxwell Experiences
 */

require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/helpers.php';

// Verificar autenticación
requireAuth();

// Obtener datos del usuario
$userData = getCurrentUserData();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pageTitle ?? 'Maxwell Experiences'; ?></title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Bootstrap 5.3 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/style.css">
    
    <?php if (isset($extraCss)): ?>
        <?php foreach ($extraCss as $css): ?>
            <link rel="stylesheet" href="<?php echo BASE_URL . $css; ?>">
        <?php endforeach; ?>
    <?php endif; ?>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary sticky-top" style="background: linear-gradient(135deg, #e91e63, #9c27b0) !important;">
        <div class="container-fluid">
            <a class="navbar-brand d-flex align-items-center" href="<?php echo BASE_URL; ?>index.php">
                <i class="bi bi-heart-fill me-2"></i>
                <span class="d-none d-lg-inline">Maxwell Experiences</span>
            </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" 
                    data-bs-target="#mainNavbar" aria-controls="mainNavbar" 
                    aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="mainNavbar">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) === 'index.php' ? 'active' : ''; ?>" 
                           href="<?php echo BASE_URL; ?>index.php">
                            <i class="bi bi-speedometer2 me-1"></i> Dashboard
                        </a>
                    </li>
                    
                    <!-- Paquetes -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle <?php echo strpos($_SERVER['PHP_SELF'], 'packages') !== false ? 'active' : ''; ?>" 
                           href="#" id="packagesDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-box2-heart me-1"></i> Paquetes
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="packagesDropdown">
                            <li><a class="dropdown-item" href="<?php echo BASE_URL; ?>modules/packages/index.php">
                                <i class="bi bi-list me-2"></i>Listado de Paquetes
                            </a></li>
                            <li><a class="dropdown-item" href="<?php echo BASE_URL; ?>modules/packages/create.php">
                                <i class="bi bi-plus-circle me-2"></i>Añadir Paquete
                            </a></li>
                        </ul>
                    </li>
                    
                    <!-- Citas -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle <?php echo strpos($_SERVER['PHP_SELF'], 'appointments') !== false ? 'active' : ''; ?>" 
                           href="#" id="appointmentsDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-calendar-heart me-1"></i> Citas
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="appointmentsDropdown">
                            <li><a class="dropdown-item" href="<?php echo BASE_URL; ?>modules/appointments/index.php">
                                <i class="bi bi-list me-2"></i>Listado de Citas
                            </a></li>
                            <li><a class="dropdown-item" href="<?php echo BASE_URL; ?>modules/appointments/create.php">
                                <i class="bi bi-calendar-plus me-2"></i>Agendar Cita
                            </a></li>
                        </ul>
                    </li>
                    
                    <?php if (isAdmin()): ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle <?php echo strpos($_SERVER['PHP_SELF'], 'user_management') !== false ? 'active' : ''; ?>"
                           href="#" id="usersDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-person-gear me-1"></i> Admin
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="usersDropdown">
                            <li><a class="dropdown-item" href="<?php echo BASE_URL; ?>modules/user_management/index.php">
                                <i class="bi bi-list me-2"></i>Usuarios
                            </a></li>
                        </ul>
                    </li>
                    <?php endif; ?>
                </ul>
                
                <?php include __DIR__ . '/user_menu.php'; ?>
            </div>
        </div>
    </nav>
    
    <main class="container-fluid py-4">
        <?php if (hasFlash('success')): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle me-2"></i><?php echo getFlash('success'); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>
        <?php if (hasFlash('error')): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-triangle me-2"></i><?php echo getFlash('error'); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>
