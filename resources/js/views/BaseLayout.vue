<template>
  <div>
    <ajax-loader :show="showLoader"></ajax-loader>

    <!-- Header -->
    <nav class="navbar navbar-expand-lg navbar-light">
      <router-link to="/" tag="a" class="navbar-brand pt-1">Timesheet</router-link>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNavDropdown">
        <!-- Navigation links -->
        <ul class="navbar-nav">
          <router-link to="/" tag="li" class="nav-item" exact>
            <a class="nav-link"><span class="ti-home"></span> Home</a>
          </router-link>
          <router-link to="/projects" tag="li" class="nav-item">
            <a class="nav-link"><span class="ti-list"></span> Projects</a>
          </router-link>
        </ul>
        <!--/ Navigation links -->
      </div>

      <!-- User actions -->
      <template v-if="$route.path != '/'">
        <div class="dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <img :src="$appURL + 'images/user.png'" alt="" width="40">
          </a>
          <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
            <a class="dropdown-item" href="#" @click.prevent="$eventBus.$emit('logout')">Logout</a>
          </div>
        </div>
      </template>
      <!--/ User actions -->
      
    </nav>
    <!--/ Header -->

    <!-- Content -->
    <div class="container-fluid">
      <slot></slot>
    </div>
    <!--/ Content -->

  </div>
</template>

<script>
import AjaxLoader from '../components/AjaxLoader';

export default {
  components: {
    AjaxLoader
  },
  data () {
    return {
      //
    }
  },
  computed: {
    /**
     * Show loader.
     */
    showLoader () {
      return this.$root.showLoader;
    } 
  }
}
</script>
