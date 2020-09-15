<!-- GENERATED CUSTOM COLORS -->
<style>
    .top-nav {
        background-color: {{ config('settings.primary_color') ? config('settings.primary_color') : '#007bff' }} !important;
    }
    .bottom-nav {
        background-color: {{ config('settings.secondary_color') ? config('settings.secondary_color') : '#4E5E6A' }} !important;
    }
    .type_title.active {
        background-color: {{ config('settings.secondary_color') ? config('settings.secondary_color') : '#4E5E6A' }} !important;
    }
    .btn-outline-dark {
        border-color: {{ config('settings.secondary_color') ? config('settings.secondary_color') : '#4E5E6A' }} !important;
    }
    .btn-outline-dark:hover {
        background-color: {{ config('settings.secondary_color') ? config('settings.secondary_color') : '#4E5E6A' }} !important;
    }
    .btn-primary {
        color:#FFFFFF !important;
    }
    .btn-danger {
        color:#FFFFFF !important;
    }
    .btn-dark {
        color:#FFFFFF !important;
    }
    .fas {
        color:{{ config('settings.primary_color') ? config('settings.primary_color') : '#007bff' }} !important;
    }
    .text-primary {
        color:{{ config('settings.primary_color') ? config('settings.primary_color') : '#007bff' }} !important;
    }
    .footer {
        background-color: {{ config('settings.secondary_color') ? config('settings.secondary_color') : '#4E5E6A' }} !important;
    }
</style>