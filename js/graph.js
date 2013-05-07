
//graph constructor
function Graph() {
    this._numVertices = 0;
    this._node_list = new Array();  
}


Graph.prototype = {
    
    add_node: function(id, data, edges){
      
        //create new vertex w/ data and pointers
        var vertex = {
            id: id,
            data: data,
            edges: edges
        }

        this._node_list[this._numVertices++] = vertex;
    },
    
    add_edges: function(id, connected_node){
        
        var flag1 = 0;
        var flag2 = 0;
        var tmp_hldr1 = 0;
        var tmp_hldr2 = 0;
        
        for (i = 0; i < this._node_list.length; i++) {
            
            if (this._node_list[i].id == id){
               flag1 = 1;
               tmp_hldr1 = i;
            } 
            if (this._node_list[i].id == connected_node) {
               flag2 = 1;
               tmp_hldr2 = i;
            }
            
        }
       
        if (flag1 === 1 && flag2 === 1) 
            this._node_list[tmp_hldr1].edges.push(connected_node);
        else
            console.log("Node not added.");
    },
    
    update_data: function(id, data){
        
        for (i = 0; i < this._node_list.length; i++) {
            
            if (this._node_list[i].id == id)
               this._node_list[i].data = data;
            
        }
    },
    
    
};
