
public class InventarioUI {

    private JFrame frame;
    private JTable table;
    private InventarioDAO inventarioDAO;

    public InventarioUI() {
        inventarioDAO = new InventarioDAO();
        initialize();
    }

    private void initialize() {
        frame = new JFrame();
        frame.setBounds(100, 100, 450, 300);
        frame.setDefaultCloseOperation(JFrame.EXIT_ON_CLOSE);
        frame.getContentPane().setLayout(new BorderLayout(0, 0));

    

        JButton btnAdd = new JButton("Añadir Elemento");
        btnAdd.addActionListener(this::accionAnadir);
        frame.getContentPane().add(btnAdd, BorderLayout.SOUTH);
    }

    private void accionAnadir(ActionEvent e) {

    }

    public static void main(String[] args) {
        EventQueue.invokeLater(() -> {
            try {
                InventarioUI window = new InventarioUI();
                window.frame.setVisible(true);
            } catch (Exception e) {
                e.printStackTrace();
            }
        });
    }
}