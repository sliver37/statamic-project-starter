---
id: home
blueprint: pages
title: Home
template: default
buildamic:
  -
    uuid: 0ba93e5b-d9ea-419d-89be-c11a0ce0e8b8
    type: section
    config:
      enabled: true
      buildamic_settings:
        admin_label: section
        inline:
          background:
            gradient:
              value: null
    value:
      -
        uuid: 70501a7d-5e88-4d0c-8cbe-33959bbec200
        type: row
        config:
          enabled: true
          buildamic_settings:
            admin_label: row
            column_count_total: 12
            inline:
              background:
                gradient:
                  value: null
            attributes:
              column_count_total: 12
        value:
          -
            uuid: 8b8067c0-99f1-49e8-8297-f719170b51d4
            type: column
            config:
              enabled: true
              buildamic_settings:
                admin_label: column
                columnSizes:
                  xs: 12
                  sm: null
                  md: 6
                  lg: '6'
                  xl: null
                inline:
                  background:
                    gradient:
                      value: null
            value:
              -
                uuid: 17d5f542-2957-481e-8995-016ba9a5a03c
                type: set
                config:
                  statamic_settings:
                    field:
                      type: null
                    handle: blurbs
                  buildamic_settings:
                    enabled: true
                    admin_label: blurbs
                    inline:
                      background:
                        gradient:
                          value: null
                value:
                  title: 'This is a test'
                  title_level: h1
                  title_weight: null
                  leading: null
                  title_size: text-6xl
                  title_color: text-black
                  image:
                    - branding/logo.png
                  image_align: null
                  content:
                    -
                      type: paragraph
                      content:
                        -
                          type: text
                          text: 'A test of the blurb module'
                  buttons:
                    -
                      text: Button
                      url: '#'
                      disable_icon: false
                      type: button
                      enabled: true
                  show_advanced_options: false
                  content_wrapper_class: null
                  image_wrapper_class: null
                  image_class: 'mb-6 flex'
                  blurb_wrapper_class: null
          -
            uuid: 26533896-dc4d-4c9d-b793-c38f88244922
            type: column
            config:
              enabled: true
              buildamic_settings:
                admin_label: column
                columnSizes:
                  xs: 12
                  sm: null
                  md: 6
                  lg: '6'
                  xl: null
                inline:
                  background:
                    gradient:
                      value: null
            value:
              -
                uuid: 7f90966e-ea6a-4b3a-a3bc-0449f1be693f
                type: field
                config:
                  statamic_settings:
                    handle: slider
                    field:
                      type: entries
                  buildamic_settings:
                    enabled: true
                    admin_label: slider
                    inline:
                      background:
                        gradient:
                          value: null
                value: b06b7e58-0903-45ff-bd70-7da7fa58f1d7
      -
        uuid: 2666f0f0-054d-4b1a-b0f6-59ff5362e69e
        type: row
        config:
          enabled: true
          buildamic_settings:
            admin_label: row
            column_count_total: 12
            inline:
              background:
                gradient:
                  value: null
            attributes:
              column_count_total: 12
        value:
          -
            uuid: f4fd4598-2b87-4fe7-a3f3-73e0a57e3b8d
            type: column
            config:
              enabled: true
              buildamic_settings:
                admin_label: column
                columnSizes:
                  xs: 12
                  sm: null
                  md: null
                  lg: '12'
                  xl: null
                inline:
                  background:
                    gradient:
                      value: null
            value:
              -
                uuid: dfc41ad0-b6ca-4efd-9e06-b9c99533794a
                type: set
                config:
                  statamic_settings:
                    field:
                      type: null
                    handle: gallery
                  buildamic_settings:
                    enabled: true
                    admin_label: 'gallery as slider'
                    inline:
                      background:
                        gradient:
                          value: null
                value:
                  images:
                    - 4CuUj2s63VE.jpg
                    - cJZvhZ1CXgE.jpg
                    - CYgtO2b0tTw.jpg
                    - DU1D4TwgVXU.jpg
                    - o6Qwcv-abjs.jpg
                    - rZyQOtBZ1XI.jpg
                  columns: null
                  image_class: null
                  gallery_slider: true
      -
        uuid: 13ead6ce-2eee-44b0-b9b1-1044ebbff329
        type: row
        config:
          enabled: true
          buildamic_settings:
            admin_label: row
            column_count_total: 12
            inline:
              background:
                gradient:
                  value: null
            attributes:
              column_count_total: 12
        value:
          -
            uuid: f2d80c40-b5e8-47d7-9941-08ce909c3621
            type: column
            config:
              enabled: true
              buildamic_settings:
                admin_label: column
                columnSizes:
                  xs: 12
                  sm: null
                  md: null
                  lg: '12'
                  xl: null
                inline:
                  background:
                    gradient:
                      value: null
            value:
              -
                uuid: 5c39e92c-4b6a-4286-8a7f-cbe9fe9c07b9
                type: set
                config:
                  statamic_settings:
                    field:
                      type: null
                    handle: gallery
                  buildamic_settings:
                    enabled: true
                    admin_label: 'gallery as grid'
                    inline:
                      background:
                        gradient:
                          value: null
                value:
                  images:
                    - 4CuUj2s63VE.jpg
                    - cJZvhZ1CXgE.jpg
                    - CYgtO2b0tTw.jpg
                    - DU1D4TwgVXU.jpg
                    - o6Qwcv-abjs.jpg
                    - rZyQOtBZ1XI.jpg
                  columns: grid-cols-4
                  image_class: test
                  gallery_slider: false
author: 37013ff3-f23e-424f-9e6c-c8b8608b3079
protected: false
show_page_title: true
updated_by: 37013ff3-f23e-424f-9e6c-c8b8608b3079
updated_at: 1650510507
show_excerpt_in_header: true
enable_header_content_right: false
---
Welcome to your new Statamic website.
