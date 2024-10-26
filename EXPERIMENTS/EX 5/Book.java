import java.io.IOException;
import java.io.PrintWriter;
import java.sql.Connection;
import java.sql.DriverManager;
import java.sql.PreparedStatement;
import java.sql.ResultSet;
import javax.servlet.ServletException;
import javax.servlet.annotation.WebServlet;
import javax.servlet.http.HttpServlet;
import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;

@WebServlet("/BookServlet")
public class BookServlet extends HttpServlet {
    protected void doPost(HttpServletRequest request, HttpServletResponse response)
            throws ServletException, IOException {
        
        response.setContentType("text/html");
        PrintWriter out = response.getWriter();

        // Fetch form data
        String title = request.getParameter("title");
        String author = request.getParameter("author");
        String publisher = request.getParameter("publisher");
        String edition = request.getParameter("edition");
        String price = request.getParameter("price");

        // Database connection
        Connection conn = null;
        PreparedStatement pst = null;

        try {
            // Load the MySQL driver
            Class.forName("com.mysql.cj.jdbc.Driver");

            // Connect to the database
            conn = DriverManager.getConnection("jdbc:mysql://localhost:3306/LibraryDB", "root", "password");

            // Insert book information into the database
            String sql = "INSERT INTO BOOK (TITLE, AUTHOR, PUBLISHER, EDITION, PRICE) VALUES (?, ?, ?, ?, ?)";
            pst = conn.prepareStatement(sql);
            pst.setString(1, title);
            pst.setString(2, author);
            pst.setString(3, publisher);
            pst.setString(4, edition);
            pst.setString(5, price);

            int row = pst.executeUpdate();
            if (row > 0) {
                out.println("<h3>Book information added successfully!</h3>");
            }

            // Display all book information
            sql = "SELECT * FROM BOOK";
            pst = conn.prepareStatement(sql);
            ResultSet rs = pst.executeQuery();

            out.println("<h2>All Book Information</h2>");
            out.println("<table border='1'><tr><th>Acc No</th><th>Title</th><th>Author</th><th>Publisher</th><th>Edition</th><th>Price</th></tr>");
            while (rs.next()) {
                out.println("<tr><td>" + rs.getInt("ACCNO") + "</td><td>" + rs.getString("TITLE") + "</td><td>" + rs.getString("AUTHOR") + "</td><td>" + rs.getString("PUBLISHER") + "</td><td>" + rs.getString("EDITION") + "</td><td>" + rs.getDouble("PRICE") + "</td></tr>");
            }
            out.println("</table>");
        } catch (Exception e) {
            out.println("Error: " + e.getMessage());
        } finally {
            try {
                if (pst != null) pst.close();
                if (conn != null) conn.close();
            } catch (Exception e) {
                out.println("Error closing connection: " + e.getMessage());
            }
        }
    }
}
