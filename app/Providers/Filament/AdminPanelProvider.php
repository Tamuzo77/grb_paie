<?php

namespace App\Providers\Filament;

use App\Filament\Pages\Dashboard;
use BezhanSalleh\FilamentShield\FilamentShieldPlugin;
use Filament\FontProviders\GoogleFontProvider;
use Filament\Forms\Components\FileUpload;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Navigation\MenuItem;
use Filament\Navigation\NavigationGroup;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets;
use Hasnayeen\Themes\Http\Middleware\SetTheme;
use Hasnayeen\Themes\ThemesPlugin;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Jeffgreco13\FilamentBreezy\BreezyCore;
use Leandrocfe\FilamentApexCharts\FilamentApexChartsPlugin;
use pxlrbt\FilamentEnvironmentIndicator\EnvironmentIndicatorPlugin;
use pxlrbt\FilamentSpotlight\SpotlightPlugin;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
//            ->font('Montserrat Alternates', provider: GoogleFontProvider::class)
            ->path('admin')
            ->login()
            ->brandLogo(fn () => view('filament.admin.logo-light'))
            ->darkModeBrandLogo(fn () => view('filament.admin.logo'))
            ->brandLogoHeight('3.5rem')
            ->passwordReset()
            ->emailVerification()
            ->profile()
            ->resources([
                config('filament-logger.activity_resource'),
            ])
//            ->userMenuItems([
//                'profile' => MenuItem::make()
//                    ->label('Profile')
//                    ->icon('heroicon-o-user-circle')
//                    ->url(static fn () => url('admin/profile')),
//            ])
            ->colors([
                'primary' => '#009fe6',
                'secondary' => '#008ea6',
                'accent' => '#0087ff',
                'neutral' => '#1e3026',
                'base-100' => '#28282e',
                'info' => '#00a4d4',
                'success' => '#00e5aa',
                'warning' => '#bb9900',
                'error' => '#ff8a90',
                'gray' => Color::Slate,
                'tertiary' => Color::Amber,

            ])
//            ->font('K2D')
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->discoverClusters(in: app_path('Filament/Clusters'), for: 'App\\Filament\\Clusters')
            ->sidebarFullyCollapsibleOnDesktop()
            ->pages([
                //                Pages\Dashboard::class,
                Dashboard::class,
            ])
            ->navigationGroups([
                NavigationGroup::make(label: 'Dépendances salariales'),
                NavigationGroup::make(label: 'Etats et Paiements'),
                NavigationGroup::make(label: 'Paramètres')
                    ->icon('heroicon-o-cog-6-tooth'),
                NavigationGroup::make('Filament Shield'),

            ])
            ->plugins([
                ThemesPlugin::make(),
                EnvironmentIndicatorPlugin::make(),
                BreezyCore::make()
                    ->myProfile(
                        hasAvatars: true,
                    )
                    ->avatarUploadComponent(fn () => FileUpload::make('avatar')->imageEditor()->storeFiles(condition: true)->directory('usersAvatars')->avatar())
                    ->passwordUpdateRules(
                        rules: [
                            'string',
                            'min:8', // must be at least 8 characters
                            'confirmed',
                            'regex:/[a-z]/', // must contain at least one lowercase letter
                            'regex:/[A-Z]/', // must contain at least one uppercase letter
                            'regex:/[0-9]/', // must contain at least one digit
                            'regex:/[@$!%*#?&]/', // must contain a special character
                        ],

                    )
                    ->enableTwoFactorAuthentication(
                    ),
                SpotlightPlugin::make(),
                FilamentShieldPlugin::make(),
                FilamentApexChartsPlugin::make(),
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->widgets([
                Widgets\AccountWidget::class,
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
                SetTheme::class,
            ])
            ->databaseNotifications()
            ->authMiddleware([
                Authenticate::class,
            ]);
    }
}
