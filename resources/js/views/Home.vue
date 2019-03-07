<template>
  <base-layout>

    <div class="home">
      <div class="row justify-content-center">
        <div class="col-md-4">
            <!-- App Time -->
            <app-time></app-time>
            <!--/ App Time -->

            <div class="card rounded shadow-sm mt-1">
              <div class="card-body">
                <div class="card-title align-middle">
                  <div class="float-left">
                    <img :src="$appURL + 'images/user.png'" :alt="$store.state.auth.user.name" class="user-image">
                  </div>
                  <div class="float-left ml-2 mt-1">
                    <div class="user-name">{{ $store.state.auth.user.name }}</div>
                    <a href="#" class="text-muted logout" @click.prevent="$eventBus.$emit('logout')">Logout</a>
                  </div>
                  <div class="clearfix"></div>
                </div>
              </div>
            </div>

        </div>
      </div>
    </div>

  </base-layout>
</template>

<script>
export default {
  components: {
    BaseLayout: require('./BaseLayout.vue').default,
    AppTime: require('../components/AppTime.vue').default
  } 
}
</script>

<style scoped>
.home .user-image {
  width: 40px;
}

.home .logout {
  font-size: 12px;
  position: relative;
  bottom: 10px;
}
</style>
