<template>
  <button
  @click="eliminarVacante"
  class="text-red-600 hover:text-red-900 mr-5"
  >Eliminar</button>
</template>

<script>
export default {
  props: ['vacanteId'],
  methods: {
    eliminarVacante() {
        //console.log('elimiandn...', this.vacanteId)

    //this.$swal('aqui vamos bien');

      this.$swal.fire({
          title: "¿Deseas eliminar esta vacante?",
          text: "Una vez eliminada, NO se puede recuperar!",
          icon: "warning",
          showCancelButton: true,
          confirmButtonColor: "#3085d6",
          cancelButtonColor: "#d33",
          confirmButtonText: "Sí, eliminar!",
          cancelButtonText: "No"
        }).then((result) => {
            if (result.value) {
            //AQUI HAY DOS FORMAS DE ENVIAR DATOS Y FUNCIONAN

/*             //PRIMERA
              const params = {
                  id: this.vacanteId,
                  _method: 'delete'
              }

            //enviar peticion AXIOS
            axios.post(`/vacantes/${this.vacanteId}`, params)
                .then(respuesta => {
                        console.log(respuesta)
                        this.$swal.fire(
                            "Eliminado!",
                            respuesta.data.mensaje,
                            "success"
                        );

                        //eliminar del dom el registro -- que se refresque la pagina
                        //se selecciona desde el dom y siempre se borra del padre hacia el hijo,
                        //por eso nos movemos entre elementos
                        this.$el.parentNode.parentNode.parentNode.removeChild(this.$el.parentNode.parentNode);
                })
                .catch(error => {
                    console.log(error);
                })
 */

            //SEGUNDA FORMA
            //enviar peticion a axios
            var url = '/vacantes/' + this.vacanteId;
            axios.delete(url)
                .then(respuesta => {
                        console.log(respuesta)
                        this.$swal.fire(
                            "Eliminado!",
                            respuesta.data.mensaje,
                            "success"
                        );

                        //eliminar del dom el registro -- que se refresque la pagina
                        //se selecciona desde el dom y siempre se borra del padre hacia el hijo,
                        //por eso nos movemos entre elementos
                        this.$el.parentNode.parentNode.parentNode.removeChild(this.$el.parentNode.parentNode);
                })
                .catch(error => {
                    console.log(error);
                })

          }
        });
    },
  },
};
</script>

