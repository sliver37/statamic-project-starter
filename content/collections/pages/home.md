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
                  title_color: null
                  image: {  }
                  content:
                    -
                      type: paragraph
                      content:
                        -
                          type: text
                          text: 'A test of the blurb module'
                  buttons: {  }
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
            value: {  }
author: 37013ff3-f23e-424f-9e6c-c8b8608b3079
protected: false
show_page_title: true
updated_by: 37013ff3-f23e-424f-9e6c-c8b8608b3079
updated_at: 1637208549
---
Welcome to your new Statamic website.
