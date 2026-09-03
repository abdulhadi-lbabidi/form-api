<?php

namespace App\Providers\Filament;

use Filament\Http\Middleware\Authenticate;
use BezhanSalleh\FilamentShield\FilamentShieldPlugin;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Navigation\NavigationGroup;
use Filament\Pages\Dashboard;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\PreventRequestForgery;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Filament\Support\HtmlString;

class AdminPanelProvider extends PanelProvider
{
  public function panel(Panel $panel): Panel
  {
    return $panel
      ->default()
      ->id('admin')
      ->path('admin')

      ->plugins([
        FilamentShieldPlugin::make(),
      ])

      ->navigationGroups([
        NavigationGroup::make()
          ->label('إدارة الشركات')
          ->collapsible(true),

        NavigationGroup::make()
          ->label('إدارة الكوادر')
          ->collapsible(true),

        NavigationGroup::make()
          ->label('إدارة العمال والتشغيل')
          ->collapsible(true),

        NavigationGroup::make()
          ->label('طلبات التقديم على الشواغر')
          ->collapsible(true),

        NavigationGroup::make()
          ->label('التسويق والإحالات')
          ->collapsible(true),

        NavigationGroup::make()
          ->label('طلبات الترقية')
          ->collapsible(true),

        NavigationGroup::make()
          ->label('الإعلانات')
          ->collapsible(true),

        NavigationGroup::make()
          ->label('المالية')
          ->collapsible(true),



        NavigationGroup::make()
          ->label('إدارة النظام')
          ->collapsible(true),

        NavigationGroup::make()
          ->label('الصلاحيات والأذونات')
          ->collapsible(true),

        NavigationGroup::make()
          ->label('إدارة الوصول')
          ->collapsible(true),


      ])
      ->login()
      ->brandName('Kadr X')
      ->brandLogo(asset('logo.png'))
      ->brandLogoHeight('4rem')
      ->darkModeBrandLogo(asset('logo-dark.png'))
      ->favicon(asset('logo.png'))

      ->renderHook(
        \Filament\View\PanelsRenderHook::GLOBAL_SEARCH_AFTER,
        fn(): \Illuminate\Support\HtmlString => new \Illuminate\Support\HtmlString('
        <a
            href="https://kadrx.com/"
            target="_blank"
            rel="noopener noreferrer"
            class="visit-website-link"
        >
            <span>🌐</span>
            <span>زيارة الموقع الإلكتروني</span>
        </a>

        <style>
            .visit-website-link {
                display: inline-flex;
                align-items: center;
                gap: 6px;
                margin-inline-start: 12px;
                font-size: 14px;
                font-weight: 600;
                text-decoration: none;
                color: var(--primary-600);
            }

            .visit-website-link:hover {
                text-decoration: underline;
            }

            .dark .visit-website-link {
                color: var(--primary-400);
            }
        </style>
    '),
      )
      ->colors([
        'primary' => Color::Teal,
      ])
      ->viteTheme('resources/css/filament/admin/theme.css')
      ->font('Cairo')
      ->sidebarCollapsibleOnDesktop()
      ->sidebarWidth('18rem')
      ->collapsedSidebarWidth('4.5rem')

      ->renderHook(
        \Filament\View\PanelsRenderHook::HEAD_END,
        fn(): \Illuminate\Support\HtmlString => new \Illuminate\Support\HtmlString('
        <style>
            html, body {
                font-size: 16px !important;
            }
            .fi-sidebar-item-label, .fi-ta-header-heading {
                font-size: 1.1rem !important;
            }
        </style>
    '),
      )
      ->globalSearch(false)
      ->databaseNotifications()
      ->discoverResources(in: app_path('Filament/Resources'), for: 'App\Filament\Resources')
      ->discoverPages(in: app_path('Filament/Pages'), for: 'App\Filament\Pages')
      ->pages([
        Dashboard::class,
      ])
      ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\Filament\Widgets')
      ->widgets([])
      ->middleware([
        EncryptCookies::class,
        AddQueuedCookiesToResponse::class,
        StartSession::class,
        AuthenticateSession::class,
        ShareErrorsFromSession::class,
        PreventRequestForgery::class,
        SubstituteBindings::class,
        DisableBladeIconComponents::class,
        DispatchServingFilamentEvent::class,
      ])
      ->authMiddleware([
        Authenticate::class,
      ]);
  }
}
