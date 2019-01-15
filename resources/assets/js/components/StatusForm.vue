<template>
	<div>
		<form @submit.prevent="submit">	    
		    <div class="card-body">
                <textarea class="form-control border-0 bg-light" 
                            v-model="body" 
                            name="body"                             
                            cols="30" 
                            rows="3" 
                            placeholder="¿Qué estas pensando?">                                
                </textarea>		    			    	
			</div>
			<div class="card-footer">
		    	<button class="btn btn-primary" id="create-status2">Publicar</button>
			</div>    
		</form>		
	</div>
</template>

<script>
    export default {
    	data(){
    		return{
    			body: ''    			
    		}
    	},
        methods: {
        	submit() {
        		axios.post('/statuses', {body: this.body})
        			.then(res => {
                        EventBus.$emit('status-created', res.data);
                        this.body = ''
        			})
        			.catch(err => {
        				console.log(err.response.data)
        			})
        	}
        }
    }
</script>

<style scoped>

</style>
