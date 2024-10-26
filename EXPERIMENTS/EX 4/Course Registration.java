import java.io.IOException;
import java.io.PrintWriter;
import javax.servlet.ServletException;
import javax.servlet.annotation.WebServlet;
import javax.servlet.http.HttpServlet;
import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;

@WebServlet("/CourseRegistrationServlet")
public class CourseRegistrationServlet extends HttpServlet {
    private static final long serialVersionUID = 1L;

    protected void doPost(HttpServletRequest request, HttpServletResponse response) throws ServletException, IOException {
        // Extracting form data
        String name = request.getParameter("name");
        String rollno = request.getParameter("rollno");
        String gender = request.getParameter("gender");
        String year = request.getParameter("year");
        String department = request.getParameter("department");
        String section = request.getParameter("section");
        String mobileNo = request.getParameter("mobile_no");
        String email = request.getParameter("email");
        String address = request.getParameter("address");
        String city = request.getParameter("city");
        String country = request.getParameter("country");
        String pincode = request.getParameter("pincode");

        // Setting the response content type
        response.setContentType("text/html");
        PrintWriter out = response.getWriter();

        // Displaying the extracted data
        out.println("<html><body>");
        out.println("<h2>Registered Student Information</h2>");
        out.println("<p><b>Student Name:</b> " + name + "</p>");
        out.println("<p><b>Roll No:</b> " + rollno + "</p>");
        out.println("<p><b>Gender:</b> " + gender + "</p>");
        out.println("<p><b>Year:</b> " + year + "</p>");
        out.println("<p><b>Department:</b> " + department + "</p>");
        out.println("<p><b>Section:</b> " + section + "</p>");
        out.println("<p><b>Mobile No:</b> " + mobileNo + "</p>");
        out.println("<p><b>E-Mail ID:</b> " + email + "</p>");
        out.println("<p><b>Address:</b> " + address + "</p>");
        out.println("<p><b>City:</b> " + city + "</p>");
        out.println("<p><b>Country:</b> " + country + "</p>");
        out.println("<p><b>Pincode:</b> " + pincode + "</p>");
        out.println("</body></html>");
    }
}
