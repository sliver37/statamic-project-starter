
        </div> <!-- End $app -->

        @stack('pre-scripts')

        <script src="{{ mix('js/site.js') }}"></script>
        {{-- <script src="https://kit.fontawesome.com/c5fd89800f.js" crossorigin="anonymous"></script> --}}

        @frostyScripts
        @stack('post-scripts')
    </body>

</html>
