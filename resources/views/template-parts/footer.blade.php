<div class="main-footer sticky top-screen buildamic-section md:pt-2 pb-0 bg-gray-200 squiggles-bottom">
    <div class="container">
        <div class="buildamic-row items-center">
            <div class="buildamic-column col-12 lg:col-3">
                <x-site-logo />
            </div>
            <div class="buildamic-column col-12 lg:col-9 flex flex-col lg:items-end">
                <div class="menu-footer mb-6 lg:mb-0">
                    <x-nav :isMain="true" class="text-white" handle="footer_nav" />
                </div>
            </div>
        </div>
    </div>
    <div class="bottom-bar bg-gray-300 py-2">
        <div class="container">
            <div class="flex text-sm text-center lg:text-base flex-col md:flex-row flex-wrap gap-4 items-center justify-between">
                <div>&copy; {{ Date('Y') }} Copyright `{{ $site->name() }}</div>
                <div class="flex gap-4">
                    <a href="#"><v-icon name="facebook"></v-icon></a>
                    <a href="#"><v-icon name="twitter"></v-icon></a>
                </div>
                <div><a href="https://www.handmadeweb.com.au" rel="nofollow" target="_blank">Website by Handmade Web &amp;
                        Design</a></div>
            </div>
        </div>
    </div>
</div>

