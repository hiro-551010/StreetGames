<template>
    <div>
        <div v-for="value of players">
            <label><input type="radio" name="checkName" :value="value.user_name">{{value.user_name}}</label>
        </div>
    </div>
    
</template>

<script>


export default {
    props:{
        players:{
            type: Object
        }
    },
}
</script>
