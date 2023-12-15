import java.sql.Connection;
import java.sql.PreparedStatement;
import java.sql.ResultSet;
import java.sql.SQLException;
import java.util.ArrayList;
import java.util.List;

public class InventarioDAO {
    public List<InventarioItem> obtenerInventario() throws SQLException {
        List<InventarioItem> inventario = new ArrayList<>();
        String sql = "SELECT * FROM inventario";
        try (Connection conn = ConexionDB.abrirConexion();
             PreparedStatement stmt = conn.prepareStatement(sql);
             ResultSet rs = stmt.executeQuery()) {

            while (rs.next()) {
                InventarioItem item = new InventarioItem(
                    rs.getInt("id"),
                    rs.getString("nombre"),
                    rs.getInt("cantidad"),
                    rs.getBigDecimal("precio"));
                inventario.add(item);
            }
        }
        return inventario;
    }

public void anadirElemento(InventarioItem item) throws SQLException {
        String sql = "INSERT INTO inventario (nombre, cantidad, precio) VALUES (?, ?, ?)";
        try (Connection conn = ConexionDB.abrirConexion();
             PreparedStatement stmt = conn.prepareStatement(sql)) {

            stmt.setString(1, item.getNombre());
            stmt.setInt(2, item.getCantidad());
            stmt.setBigDecimal(3, item.getPrecio());
            stmt.executeUpdate();
        }
    }

    public void editarElemento(InventarioItem item) throws SQLException {
        String sql = "UPDATE inventario SET nombre = ?, cantidad = ?, precio = ? WHERE id = ?";
        try (Connection conn = ConexionDB.abrirConexion();
             PreparedStatement stmt = conn.prepareStatement(sql)) {

            stmt.setString(1, item.getNombre());
            stmt.setInt(2, item.getCantidad());
            stmt.setBigDecimal(3, item.getPrecio());
            stmt.setInt(4, item.getId());
            stmt.executeUpdate();
        }
    }

    public void eliminarElemento(int id) throws SQLException {
        String sql = "DELETE FROM inventario WHERE id = ?";
        try (Connection conn = ConexionDB.abrirConexion();
             PreparedStatement stmt = conn.prepareStatement(sql)) {

            stmt.setInt(1, id);
            stmt.executeUpdate();
        }
    }
}
