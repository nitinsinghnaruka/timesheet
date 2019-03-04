<template>
  <div class="tasks">

    <div v-if="! $isEmpty(tasks)">
      <div class="list-group">
        <div class="list-group-item list-group-item-action flex-column align-items-start shadow-sm task" v-for="task in tasks" :key="task.id">
          <div class="d-flex w-100 justify-content-between">
            <h5 class="mb-1"># {{ task.name }}</h5>
            <small>{{ $moment(task.created_at).format('dddd, MMMM Do YYYY, h:mm:ss a') }}</small>
          </div>
          <div class="tags"><span class="badge badge-pill badge-info">In Progress</span></div>
          <p class="ml-3 mt-1 mb-1" v-if="task.description">{{ task.description }}</p>
          <div class="actions">
            <a href="" @click.prevent="$eventBus.$emit('showTaskDetail', task)" v-tooltip="'View Task Detail'"><span class="ti-notepad"></span></a>
            <a href="" @click.prevent="" v-tooltip="'Delete Task'"><span class="ti-trash text-danger"></span></a>
          </div>
        </div>
      </div>
    </div>
    <div v-else>
      <div class="text-center">
        <span class="ti-cloud"></span> No tasks.
      </div>
    </div>

  </div>
</template>

<script>
export default {
  props: {
    tasks: {
      type: Array,
      required: true
    }  
  }
}
</script>

<style scoped>
.tasks .task {
  background-color: transparent;
  margin-bottom: 20px;
  border: none;
}

.tasks .task .tags {
  font-size: 12px;
  margin-left: 16px; 
}

.tasks .task .actions {
  margin-top: 10px;
  margin-left: 15px; 
}

.tasks .task .actions a {
  font-size: 14px;
  color: seagreen;
  font-weight: 500;
}

.tasks .task .actions a:hover, .tasks .task .actions a:focus, .tasks .task .actions a:active {
  text-decoration: none;
}
</style>

