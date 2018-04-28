<template>
    <h1>Day: {{day}}</h1>
    <div class="block" id="block">
        <div class="form-group" v-for="sheepfold in sheepfolds">
            <label for="sel1">{{sheepfold.name}}</label>
            <select multiple class="form-control" id="sel1">
                <option v-for="sheep in sheepfold.sheeps">{{sheep.name}}</option>
            </select>
        </div>
    </div>
</template>

<script>
  export default {
    props: ['sheepfolds', 'day']
  };
</script>
