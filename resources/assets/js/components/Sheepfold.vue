<template>
    <h1>Day: {{day}}</h1>
    <div class="block" id="block">
        <div class="form-group" v-for="sheepfold in sheepfolds">
            <label for="sel1">{{sheepfold.name}}</label>
            <select multiple class="form-control" v-model="selected" @change="selectSheep">
                <option v-for="sheep in sheepfold.sheeps" v-bind:value="sheep.id">{{sheep.name}}</option>
            </select>
        </div>
    </div>
</template>

<script>
  export default {
    props: ['sheepfolds', 'day'],
    data() {
        return {
            selected: ''
        }
    },
    methods : {
        selectSheep() {
            this.$emit('selectsheep', {
                id: this.selected
            });
        }
    }
  };
</script>
