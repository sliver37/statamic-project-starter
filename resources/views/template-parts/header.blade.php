<div v-toggle-on-scroll id="main-header" class="main-header top-0 z-50 sticky lg:relative squiggles-top bg-gray-100 py-6">
    <div class="container">
        <div class="flex items-center">
            <x-site-logo />
            <div class="flex flex-row lg:flex-col items-end ml-auto">
              <tele-mobile :order="9999">
                <div class="border-t-2 border-dashed border-gray-500 lg:border-none pt-6 mt-2 lg:py-2 lg:mt-0 mb-2 flex flex-col lg:flex-row gap-6 lg:gap-8 lg:items-center">
                    <a href="/advanced-search" class="search flex items-center gap-2 text-tertiary">
                        <v-icon class="w-6 h-6" name="search"></v-icon> <span class="lg:hidden">advanced search</span>
                    </a>
                </div>
              </tele-mobile>
              <x-nav handle="primary_navigation" :isMain="true" :hasToggle="true" />
            </div>
        </div>
    </div>
</div>
