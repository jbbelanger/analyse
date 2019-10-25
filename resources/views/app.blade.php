<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <link rel="stylesheet" href="{!! mix('css/app.css') !!}">
        <!--<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Material+Icons">-->

        <title>UQÀM Analytica</title>
        <style>
          .headline, .application, .ilisarniq, .title-ilisarniq {
            font-family: 'Ilisarniq','Roboto', sans-serif !important;
          },
          a:hover {
            text-decoration: none;
          }
          .v-navigation-drawer__border {
            display: none;
          }
        </style>
    </head>
    <body>
      <v-app id="app">
        <v-navigation-drawer v-model="drawer" app clipped color="transparent">
          <navigation />
        </v-navigation-drawer>

        <v-app-bar app clipped-left>
          <v-app-bar-nav-icon @click.stop="drawer = !drawer"></v-app-bar-nav-icon>

          <v-toolbar-title>
            <span>UQÀM </span><span>ANALYTICA</span>
          </v-toolbar-title>
          <div class="flex-grow-1"></div>

          <!--<v-btn :to="{name:'circonscriptions'}" text >Circonscriptions</v-btn>
          <v-btn :to="{name:'partis'}" text >Partis</v-btn>
          <v-btn :to="{name:'personnes'}"  >Personnes</v-btn>-->
          <v-menu
            v-model="menu"
            :close-on-content-click="false"
          >
            <template v-slot:activator="{ on }">
              <v-btn
                icon
                v-on="on"
              >
                <v-icon>mdi-dots-vertical</v-icon>
              </v-btn>
            </template>
            <v-card>
              <v-card-text>
                <v-list>
                  <v-list-item>
                    <v-list-item-avatar>
                      <v-list-item-avatar><v-icon>mdi-theme-light-dark</v-icon></v-list-item-avatar>
                    </v-list-item-avatar>
                    <v-list-item-title>Mode sombre</v-list-item-title>
                    <v-list-item-action>
                      <v-switch v-model="$vuetify.theme.dark"></v-switch>
                    </v-list-item-action>
                  </v-list-item>
                </v-list>
              </v-card-text>
            </v-card>
          </v-menu>
        </v-app-bar>

        <v-content>
          <v-container fluid>
            <router-view/>
          </v-conatiner>
        </v-content>

        <v-footer app>
          <!-- -->
        </v-footer>
      </v-app>
      <script src="{!! mix('js/app.js') !!}"></script>
    </body>
</html>
