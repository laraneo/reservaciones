<?php 
include('inc/conexion.php')


      $sql = "SELECT   MAX(m.id),  m.id, t.ID,  t.reference, t.user_id, u.name, u.username, u.email,  m.subject, m.body, MAX(m.posted) posted,   t.ticket_status_id,  st.title estatus, t.ticket_dept_id, dep.title, t.opened, 		t.closed, t.lastupdate

                FROM  cquko_fss_ticket_status st, cquko_fss_ticket_dept dep, cquko_users u, cquko_fss_ticket_ticket t, cquko_fss_ticket_messages m

                WHERE u.id = t.user_id

                AND t.ticket_status_id = st.id

                AND t.ticket_dept_id = dep.id

                AND m.ticket_ticket_id = t.id

                AND m.subject <>'Audit Message' AND st.title <> 'Closed'

               GROUP BY t.id

                ORDER BY opened DESC, reference asc";


                $result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        echo "id: " . $row["id"]. " - Name: " . $row["firstname"]. " " . $row["lastname"]. "<br>";
    }
} else {
    echo "0 results";
}
$conn->close();
?>