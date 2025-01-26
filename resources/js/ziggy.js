const Ziggy = {
    url: "http://localhost",
    port: null,
    defaults: {},
    routes: {
        "filament.exports.download": {
            uri: "filament/exports/{export}/download",
            methods: ["GET", "HEAD"],
            parameters: ["export"],
            bindings: { export: "id" },
        },
        "filament.imports.failed-rows.download": {
            uri: "filament/imports/{import}/failed-rows/download",
            methods: ["GET", "HEAD"],
            parameters: ["import"],
            bindings: { import: "id" },
        },
        "filament.admin.auth.login": {
            uri: "admin/login",
            methods: ["GET", "HEAD"],
        },
        "filament.admin.auth.logout": {
            uri: "admin/logout",
            methods: ["POST"],
        },
        "filament.admin.pages.dashboard": {
            uri: "admin",
            methods: ["GET", "HEAD"],
        },
        "filament.admin.resources.orders.index": {
            uri: "admin/orders",
            methods: ["GET", "HEAD"],
        },
        "filament.admin.resources.orders.create": {
            uri: "admin/orders/create",
            methods: ["GET", "HEAD"],
        },
        "filament.admin.resources.orders.edit": {
            uri: "admin/orders/{record}/edit",
            methods: ["GET", "HEAD"],
            parameters: ["record"],
        },
        "filament.admin.resources.products.index": {
            uri: "admin/products",
            methods: ["GET", "HEAD"],
        },
        "filament.admin.resources.products.create": {
            uri: "admin/products/create",
            methods: ["GET", "HEAD"],
        },
        "filament.admin.resources.products.edit": {
            uri: "admin/products/{record}/edit",
            methods: ["GET", "HEAD"],
            parameters: ["record"],
        },
        "filament.admin.resources.promos.index": {
            uri: "admin/promos",
            methods: ["GET", "HEAD"],
        },
        "filament.admin.resources.promos.create": {
            uri: "admin/promos/create",
            methods: ["GET", "HEAD"],
        },
        "filament.admin.resources.promos.edit": {
            uri: "admin/promos/{record}/edit",
            methods: ["GET", "HEAD"],
            parameters: ["record"],
        },
        "filament.admin.resources.settings.index": {
            uri: "admin/settings",
            methods: ["GET", "HEAD"],
        },
        "filament.admin.resources.settings.edit": {
            uri: "admin/settings/{record}/edit",
            methods: ["GET", "HEAD"],
            parameters: ["record"],
        },
        "filament.admin.resources.users.index": {
            uri: "admin/users",
            methods: ["GET", "HEAD"],
        },
        "filament.admin.resources.users.create": {
            uri: "admin/users/create",
            methods: ["GET", "HEAD"],
        },
        "filament.admin.resources.users.edit": {
            uri: "admin/users/{record}/edit",
            methods: ["GET", "HEAD"],
            parameters: ["record"],
        },
        "sanctum.csrf-cookie": {
            uri: "sanctum/csrf-cookie",
            methods: ["GET", "HEAD"],
        },
        "livewire.update": { uri: "livewire/update", methods: ["POST"] },
        "livewire.upload-file": {
            uri: "livewire/upload-file",
            methods: ["POST"],
        },
        "livewire.preview-file": {
            uri: "livewire/preview-file/{filename}",
            methods: ["GET", "HEAD"],
            parameters: ["filename"],
        },
        "ignition.healthCheck": {
            uri: "_ignition/health-check",
            methods: ["GET", "HEAD"],
        },
        "ignition.executeSolution": {
            uri: "_ignition/execute-solution",
            methods: ["POST"],
        },
        "ignition.updateConfig": {
            uri: "_ignition/update-config",
            methods: ["POST"],
        },
        "landing.page": { uri: "/", methods: ["GET", "HEAD"] },
        "products.index": { uri: "products", methods: ["GET", "HEAD"] },
        "products.show": {
            uri: "products/{id}",
            methods: ["GET", "HEAD"],
            parameters: ["id"],
        },
        "reports.orders": {
            uri: "reports/orders/{id}",
            methods: ["GET", "HEAD"],
            parameters: ["id"],
        },
        "reports.monthly": { uri: "reports/monthly", methods: ["GET", "HEAD"] },
        login: { uri: "login", methods: ["GET", "HEAD"] },
        logout: { uri: "logout", methods: ["POST"] },
        "cart.index": { uri: "cart", methods: ["GET", "HEAD"] },
        "cart.store": { uri: "cart", methods: ["POST"] },
        "cart.show": {
            uri: "cart/{cartItem}",
            methods: ["GET", "HEAD"],
            parameters: ["cartItem"],
        },
        "cart.update": {
            uri: "cart/{cartItem}",
            methods: ["PATCH"],
            parameters: ["cartItem"],
            bindings: { cartItem: "id" },
        },
        "cart.destroy": {
            uri: "cart/{cartItem}",
            methods: ["DELETE"],
            parameters: ["cartItem"],
            bindings: { cartItem: "id" },
        },
        "cart.add": { uri: "cart/add", methods: ["POST"] },
        "checkout.index": { uri: "checkout", methods: ["GET", "HEAD"] },
        "checkout.apply-promo": {
            uri: "checkout/apply-promo",
            methods: ["POST"],
        },
        "checkout.process": { uri: "checkout/process", methods: ["POST"] },
    },
};
if (typeof window !== "undefined" && typeof window.Ziggy !== "undefined") {
    Object.assign(Ziggy.routes, window.Ziggy.routes);
}
export { Ziggy };
